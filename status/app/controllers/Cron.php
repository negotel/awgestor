<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Language;

class Cron extends Controller {

    public function index() {
        die();
    }

    private function initiate() {
        /* Initiation */
        set_time_limit(0);

        /* Make sure the key is correct */
        if(!isset($_GET['key']) || (isset($_GET['key']) && $_GET['key'] != settings()->cron->key)) {
            die();
        }
    }

    public function reset() {

        $this->initiate();

        $date = \Altum\Date::$date;

        /* Delete old users logs */
        $ninety_days_ago_datetime = (new \DateTime())->modify('-90 days')->format('Y-m-d H:i:s');
        database()->query("DELETE FROM `users_logs` WHERE `date` < '{$ninety_days_ago_datetime}'");

        /* Make sure the reset date month is different than the current one to avoid double resetting */
        $reset_date = (new \DateTime(settings()->cron->reset_date))->format('m');
        $current_date = (new \DateTime())->format('m');

        if($reset_date != $current_date) {

            /* Update the settings with the updated time */
            $cron_settings = json_encode([
                'key' => settings()->cron->key,
                'reset_date' => $date
            ]);

            /* Database query */
            db()->where('`key`', 'cron')->update('settings', ['value' => $cron_settings]);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItem('settings');
        }
    }

    public function monitors() {

        $this->initiate();

        $date = \Altum\Date::$date;

        /* Get potential monitors from users that have almost all the conditions to get an email report right now */
        $result = database()->query("
            SELECT
                `monitors`.*,
                   
                `users`.`email`,
                `users`.`plan_settings`,
                `users`.`language`,
                `users`.`timezone`
            FROM 
                `monitors`
            LEFT JOIN 
                `users` ON `monitors`.`user_id` = `users`.`user_id` 
            WHERE 
                `monitors`.`is_enabled` = 1
                AND `monitors`.`next_check_datetime` <= '{$date}' 
                AND `users`.`active` = 1
            LIMIT 50
        ");

        /* Get available ping servers */
        $ping_servers = (new \Altum\Models\PingServers())->get_ping_servers();

        /* Go through each result */
        while($row = $result->fetch_object()) {
            $row->plan_settings = json_decode($row->plan_settings);
            $row->settings = json_decode($row->settings);
            $row->ping_servers_ids = json_decode($row->ping_servers_ids);
            $row->notifications = json_decode($row->notifications);

            /* Make sure the monitor is not in the maintenance window */
//            if($row->settings->maintenance_window_start && $row->settings->maintenance_window_end) {
//                $current_time = (new \DateTime())->setTimezone(new \DateTimeZone($row->settings->maintenance_window_timezone));
//                $start_time = (new \DateTime($row->settings->maintenance_window_start, new \DateTimeZone($row->settings->maintenance_window_timezone)));
//                $end_time = (new \DateTime($row->settings->maintenance_window_end, new \DateTimeZone($row->settings->maintenance_window_timezone)));
//
//                $test = 1;
//
//                if(
//                    ($start_time < $end_time && $current_time >= $start_time && $current_time <= $end_time)
//                    || ($start_time > $end_time && ($current_time >= $start_time || $current_time <= $end_time))
//                ) {
//
//                    /* Skip future checks until the maintenance window has passed */
//                    $next_check_datetime = (new \DateTime())->modify('+' . $row->settings->check_interval_seconds . ' seconds')->format('Y-m-d H:i:s');
//
//
//                }
//
//            }

            /* Select a server to do the request */
            $ping_server_id = $row->ping_servers_ids[array_rand($row->ping_servers_ids)];

            /* Use default if the ping server is not accessible for some reason */
            if(!isset($ping_servers[$ping_server_id])) {
                $ping_server_id = 1;
            }
            $ping_server = $ping_servers[$ping_server_id];

            /* Local request, native server */
            if($ping_server_id == 1) {
                switch($row->type) {

                    /* Fsockopen */
                    case 'port':

                        $ping = new \JJG\Ping($row->target);
                        $ping->setTimeout($row->settings->timeout_seconds);
                        $ping->setPort($row->port);
                        $latency = $ping->ping('fsockopen');

                        if($latency !== false) {

                            $response_status_code = 0;
                            $response_time = $latency;

                            /*  :)  */
                            $is_ok = 1;
                        } else {

                            $response_status_code = 0;
                            $response_time = 0;

                            /*  :)  */
                            $is_ok = 0;

                        }

                        break;

                    /* Ping check */
                    case 'ping':

                        $ping = new \JJG\Ping($row->target);
                        $ping->setTimeout($row->settings->timeout_seconds);
                        $latency = $ping->ping(settings()->monitors_heartbeats->monitors_ping_method);

                        if($latency !== false) {

                            $response_status_code = 0;
                            $response_time = $latency;

                            /*  :)  */
                            $is_ok = 1;
                        } else {

                            $response_status_code = 0;
                            $response_time = 0;

                            /*  :)  */
                            $is_ok = 0;

                        }

                        break;

                    /* Websites check */
                    case 'website':

                        /* Set timeout */
                        \Unirest\Request::timeout($row->settings->timeout_seconds);

                        try {

                            /* Set auth */
                            \Unirest\Request::auth($row->settings->request_basic_auth_username, $row->settings->request_basic_auth_password);

                            /* Make the request to the website */
                            $method = strtolower($row->settings->request_method);

                            if(in_array($method, ['post', 'put', 'patch'])) {
                                $response = \Unirest\Request::{$method}($row->target, $row->settings->request_headers, $row->settings->request_body);
                            } else {
                                $response = \Unirest\Request::{$method}($row->target, $row->settings->request_headers);
                            }

                            /* Get info after the request */
                            $info = \Unirest\Request::getInfo();

                            /* Some needed variables */
                            $response_status_code = $info['http_code'];
                            $response_time = $info['total_time'] * 1000;

                            /* Check the response to see how we interpret the results */
                            $is_ok = 1;

                            if($response_status_code != $row->settings->response_status_code) {
                                $is_ok = 0;
                            }

                            if($row->settings->response_body && strpos($response->raw_body, $row->settings->response_body) === false) {
                                $is_ok = 0;
                            }

                            foreach($row->settings->response_headers as $response_header) {
                                $response_header->name = strtolower($response_header->name);

                                if(!isset($response->headers[$response_header->name]) || (isset($response->headers[$response_header->name]) && $response->headers[$response_header->name] != $response_header->value)) {
                                    $is_ok = 0;
                                    break;
                                }
                            }

                        } catch (\Exception $exception) {

                            $response_status_code = 0;
                            $response_time = 0;

                            /*  :)  */
                            $is_ok = 0;

                        }

                        break;
                }
            }

            /* Outside request, via a random ping server */
            else {

                /* Request the data from outside source */
                $response = \Unirest\Request::post($ping_server->url, [], [
                    'ping_method' => settings()->monitors_heartbeats->monitors_ping_method,
                    'type' => $row->type,
                    'target' => $row->target,
                    'port' => $row->port,
                    'settings' => json_encode($row->settings)
                ]);

                /* Make sure we got the proper result back */
                if(!isset($response->body->is_ok)) {
                    continue;
                }

                $is_ok = $response->body->is_ok;
                $response_time = $response->body->response_time;
                $response_status_code = $response->body->response_status_code;

            }

            /* Assuming, based on the check interval */
            $uptime_seconds = $is_ok ? $row->uptime_seconds + $row->settings->check_interval_seconds : $row->uptime_seconds;
            $downtime_seconds = !$is_ok ? $row->downtime_seconds + $row->settings->check_interval_seconds : $row->downtime_seconds;

            /* Recalculate uptime and downtime */
            $uptime = $uptime_seconds > 0 ? $uptime_seconds / ($uptime_seconds + $downtime_seconds) * 100 : 0;
            $downtime = 100 - $uptime;

            $total_ok_checks = $is_ok ? $row->total_ok_checks + 1 : $row->total_ok_checks;
            $total_not_ok_checks = !$is_ok ? $row->total_not_ok_checks + 1 : $row->total_not_ok_checks;
            $last_check_datetime = \Altum\Date::$date;
            $next_check_datetime = (new \DateTime())->modify('+' . $row->settings->check_interval_seconds . ' seconds')->format('Y-m-d H:i:s');
            $main_ok_datetime = !$row->is_ok && $is_ok ? \Altum\Date::$date : $row->main_ok_datetime;
            $last_ok_datetime = $is_ok ? \Altum\Date::$date : $row->last_ok_datetime;
            $main_not_ok_datetime = $row->is_ok && !$is_ok ? \Altum\Date::$date : $row->main_not_ok_datetime;
            $last_not_ok_datetime = !$is_ok ? \Altum\Date::$date : $row->last_not_ok_datetime;

            $average_response_time = $is_ok ? ($row->average_response_time + $response_time) / ($row->total_ok_checks == 0 ? 1 : 2) : $row->average_response_time;

            /* Insert the history log */
            $monitor_log_id = db()->insert('monitors_logs', [
                'monitor_id' => $row->monitor_id,
                'ping_server_id' => $ping_server_id,
                'user_id' => $row->user_id,
                'is_ok' => $is_ok,
                'response_time' => $response_time,
                'response_status_code' => $response_status_code,
                'datetime' => \Altum\Date::$date
            ]);

            /* Create / update an incident if needed */
            $incident_id = $row->incident_id;

            if(!$is_ok && !$row->incident_id) {

                /* Database query */
                $incident_id = db()->insert('incidents', [
                    'monitor_id' => $row->monitor_id,
                    'start_monitor_log_id' => $monitor_log_id,
                    'start_datetime' => \Altum\Date::$date
                ]);

                if($row->plan_settings->email_notifications_is_enabled && $row->notifications->email_is_enabled) {
                    /* Get the language for the user and set the timezone */
                    $language = language($row->language);
                    \Altum\Date::$timezone = $row->timezone;

                    /* Prepare the email title */
                    $email_title = sprintf($language->cron->is_not_ok->title, $row->name);

                    /* Prepare the View for the email content */
                    $data = [
                        'language' => $language,
                        'row' => $row
                    ];

                    $email_content = (new \Altum\Views\View('partials/cron/monitor_is_not_ok', (array)$this))->run($data);

                    /* Send the email */
                    send_mail($row->email, $email_title, $email_content);
                }

                /* Webhook notification */
                if($row->notifications->webhook) {
                    try {
                        \Unirest\Request::post($row->notifications->webhook, [], [
                            'monitor_id' => $row->monitor_id,
                            'name' => $row->name,
                            'is_ok' => $is_ok,
                        ]);
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Slack notification */
                if($row->notifications->slack) {
                    try {
                        \Unirest\Request::post(
                            $row->notifications->slack,
                            ['Accept' => 'application/json'],
                            \Unirest\Request\Body::json([
                                'text' => sprintf(language()->monitor->slack_notifications->is_not_ok, $row->name),
                                'username' => settings()->title,
                                'icon_emoji' => ':large_red_square:'
                            ])
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Twilio Sms Notification */
                if(settings()->monitors_heartbeats->twilio_notifications_is_enabled && $row->plan_settings->twilio_notifications_is_enabled && $row->notifications->twilio) {
                    try {
                        \Unirest\Request::auth(settings()->monitors_heartbeats->twilio_sid, settings()->monitors_heartbeats->twilio_token);

                        \Unirest\Request::post(
                            sprintf('https://api.twilio.com/2010-04-01/Accounts/%s/Messages.json', settings()->monitors_heartbeats->twilio_sid),
                            [],
                            [
                                'From' => settings()->monitors_heartbeats->twilio_number,
                                'To' => $row->notifications->twilio,
                                'Body' => sprintf(language()->monitor->twilio_notifications->is_not_ok, $row->name),
                            ]
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }

                    \Unirest\Request::auth('', '');
                }
            }

            /* Close incident */
            if($is_ok && $row->incident_id) {

                /* Database query */
                db()->where('incident_id', $row->incident_id)->update('incidents', [
                    'monitor_id' => $row->monitor_id,
                    'end_monitor_log_id' => $monitor_log_id,
                    'end_datetime' => \Altum\Date::$date
                ]);

                $incident_id = null;

                /* Get details about the incident */
                $monitor_incident = db()->where('incident_id', $row->incident_id)->getOne('incidents', ['start_datetime', 'end_datetime']);

                if($row->plan_settings->email_notifications_is_enabled && $row->notifications->email_is_enabled) {
                    /* Get the language for the user */
                    $language = language($row->language);
                    \Altum\Date::$timezone = $row->timezone;

                    /* Prepare the email title */
                    $email_title = sprintf($language->cron->is_ok->title, $row->name);

                    /* Prepare the View for the email content */
                    $data = [
                        'language' => $language,
                        'monitor_incident' => $monitor_incident,
                        'row' => $row
                    ];

                    $email_content = (new \Altum\Views\View('partials/cron/monitor_is_ok', (array)$this))->run($data);

                    /* Send the email */
                    send_mail($row->email, $email_title, $email_content);
                }

                /* Webhook notification */
                if($row->notifications->webhook) {
                    try {
                        \Unirest\Request::post($row->notifications->webhook, [], [
                            'monitor_id' => $row->monitor_id,
                            'name' => $row->name,
                            'is_ok' => $is_ok,
                        ]);
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Slack notification */
                if($row->notifications->slack) {
                    try {
                        \Unirest\Request::post(
                            $row->notifications->slack,
                            ['Accept' => 'application/json'],
                            \Unirest\Request\Body::json([
                                'text' => sprintf(language()->monitor->slack_notifications->is_ok, $row->name),
                                'username' => settings()->title,
                                'icon_emoji' => ':large_green_circle:'
                            ])
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Twilio Sms Notification */
                if(settings()->monitors_heartbeats->twilio_notifications_is_enabled && $row->plan_settings->twilio_notifications_is_enabled && $row->notifications->twilio) {
                    try {
                        \Unirest\Request::auth(settings()->monitors_heartbeats->twilio_sid, settings()->monitors_heartbeats->twilio_token);

                        \Unirest\Request::post(
                            sprintf('https://api.twilio.com/2010-04-01/Accounts/%s/Messages.json', settings()->monitors_heartbeats->twilio_sid),
                            [],
                            [
                                'From' => settings()->monitors_heartbeats->twilio_number,
                                'To' => $row->notifications->twilio,
                                'Body' => sprintf(language()->monitor->twilio_notifications->is_ok, $row->name),
                            ]
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }

                    \Unirest\Request::auth('', '');
                }
            }

            /* Update the monitor */
            db()->where('monitor_id', $row->monitor_id)->update('monitors', [
                'incident_id' => $incident_id,
                'is_ok' => $is_ok,
                'uptime' => $uptime,
                'uptime_seconds' => $uptime_seconds,
                'downtime' => $downtime,
                'downtime_seconds' => $downtime_seconds,
                'average_response_time' => $average_response_time,
                'total_checks' => db()->inc(),
                'total_ok_checks' => $total_ok_checks,
                'total_not_ok_checks' => $total_not_ok_checks,
                'last_check_datetime' => $last_check_datetime,
                'next_check_datetime' => $next_check_datetime,
                'main_ok_datetime' => $main_ok_datetime,
                'last_ok_datetime' => $last_ok_datetime,
                'main_not_ok_datetime' => $main_not_ok_datetime,
                'last_not_ok_datetime' => $last_not_ok_datetime,
            ]);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('monitor_id=' . $row->monitor_id);

        }

    }

    public function heartbeats() {

        $this->initiate();

        $date = \Altum\Date::$date;

        /* Get potential heartbeats from users that have almost all the conditions to get an email report right now */
        $result = database()->query("
            SELECT
                `heartbeats`.*,
                   
                `users`.`email`,
                `users`.`plan_settings`,
                `users`.`language`,
                `users`.`timezone`
            FROM 
                `heartbeats`
            LEFT JOIN 
                `users` ON `heartbeats`.`user_id` = `users`.`user_id` 
            WHERE 
                `heartbeats`.`is_enabled` = 1
                AND `heartbeats`.`next_run_datetime` <= '{$date}' 
                AND `users`.`active` = 1
            LIMIT 50
        ");

        /* Go through each result */
        while($row = $result->fetch_object()) {
            $row->plan_settings = json_decode($row->plan_settings);
            $row->settings = json_decode($row->settings);
            $row->notifications = json_decode($row->notifications);

            /* Since the result is here, the cron is not working */
            $is_ok = 0;

            /* Insert the history log */
            $heartbeat_log_id = db()->insert('heartbeats_logs', [
                'heartbeat_id' => $row->heartbeat_id,
                'user_id' => $row->user_id,
                'is_ok' => $is_ok,
                'datetime' => \Altum\Date::$date,
            ]);

            /* Assuming, based on the run interval */
            $downtime_seconds_to_add = 0;
            switch($row->settings->run_interval_type) {
                case 'minutes':
                    $downtime_seconds_to_add = $row->settings->run_interval * 60;
                    break;

                case 'hours':
                    $downtime_seconds_to_add = $row->settings->run_interval * 60 * 60;
                    break;

                case 'days':
                    $downtime_seconds_to_add = $row->settings->run_interval * 60 * 60 * 24;
                    break;
            }
            $uptime_seconds = $row->uptime_seconds;
            $downtime_seconds = $row->downtime_seconds + $downtime_seconds_to_add;

            /* ^_^ */
            $uptime = $uptime_seconds > 0 ? $uptime_seconds / ($uptime_seconds + $downtime_seconds) * 100 : 0;
            $downtime = 100 - $uptime;
            $main_missed_datetime = $row->is_ok && !$is_ok ? \Altum\Date::$date : $row->main_missed_datetime;
            $last_missed_datetime = \Altum\Date::$date;

            /* Calculate expected next run */
            $next_run_datetime = (new \DateTime())
                ->modify('+' . $row->settings->run_interval . ' ' . $row->settings->run_interval_type)
                ->modify('+' . $row->settings->run_interval_grace . ' ' . $row->settings->run_interval_grace_type)
                ->format('Y-m-d H:i:s');

            /* Create / update an incident if needed */
            $incident_id = $row->incident_id;

            if(!$is_ok && !$row->incident_id) {

                /* Database query */
                $incident_id = db()->insert('incidents', [
                    'heartbeat_id' => $row->heartbeat_id,
                    'start_heartbeat_log_id' => $heartbeat_log_id,
                    'start_datetime' => \Altum\Date::$date,
                ]);

                if($row->plan_settings->email_notifications_is_enabled && $row->notifications->email_is_enabled) {
                    /* Get the language for the user and set the timezone */
                    $language = language($row->language);
                    \Altum\Date::$timezone = $row->timezone;

                    /* Prepare the email title */
                    $email_title = sprintf($language->cron->is_not_ok->title, $row->name);

                    /* Prepare the View for the email content */
                    $data = [
                        'language' => $language,
                        'row' => $row
                    ];

                    $email_content = (new \Altum\Views\View('partials/cron/heartbeat_is_not_ok', (array)$this))->run($data);

                    /* Send the email */
                    send_mail($row->email, $email_title, $email_content);
                }

                /* Webhook notification */
                if($row->notifications->webhook) {
                    try {
                        \Unirest\Request::post($row->notifications->webhook, [], [
                            'heartbeat_id' => $row->heartbeat_id,
                            'name' => $row->name,
                            'is_ok' => $is_ok,
                        ]);
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Slack notification */
                if($row->notifications->slack) {
                    try {
                        \Unirest\Request::post(
                            $row->notifications->slack,
                            ['Accept' => 'application/json'],
                            \Unirest\Request\Body::json([
                                'text' => sprintf(language()->heartbeat->slack_notifications->is_not_ok, $row->name),
                                'username' => settings()->title,
                                'icon_emoji' => ':large_red_square:'
                            ])
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }
                }

                /* Twilio Sms Notification */
                if(settings()->monitors_heartbeats->twilio_notifications_is_enabled && $row->plan_settings->twilio_notifications_is_enabled && $row->notifications->twilio) {
                    try {
                        \Unirest\Request::auth(settings()->monitors_heartbeats->twilio_sid, settings()->monitors_heartbeats->twilio_token);

                        \Unirest\Request::post(
                            sprintf('https://api.twilio.com/2010-04-01/Accounts/%s/Messages.json', settings()->monitors_heartbeats->twilio_sid),
                            [],
                            [
                                'From' => settings()->monitors_heartbeats->twilio_number,
                                'To' => $row->notifications->twilio,
                                'Body' => sprintf(language()->heartbeat->twilio_notifications->is_not_ok, $row->name),
                            ]
                        );
                    } catch (\Exception $exception) {
                        // :)
                    }

                    \Unirest\Request::auth('', '');
                }
            }

            /* Update the heartbeat */
            db()->where('heartbeat_id', $row->heartbeat_id)->update('heartbeats', [
                'incident_id' => $incident_id,
                'is_ok' => $is_ok,
                'uptime' => $uptime,
                'uptime_seconds' => $uptime_seconds,
                'downtime' => $downtime,
                'downtime_seconds' => $downtime_seconds,
                'total_missed_runs' => db()->inc(),
                'main_missed_datetime' => $main_missed_datetime,
                'last_missed_datetime' => $last_missed_datetime,
                'next_run_datetime' => $next_run_datetime,
            ]);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('heartbeat_id=' . $row->heartbeat_id);

        }

    }

    public function monitors_email_reports() {

        $this->initiate();

        /* Only run this part if the email reports are enabled */
        if(!settings()->monitors_heartbeats->email_reports_is_enabled) {
            return;
        }

        $date = \Altum\Date::$date;

        /* Determine the frequency of email reports */
        $days_interval = 7;

        switch(settings()->monitors_heartbeats->email_reports_is_enabled) {
            case 'weekly':
                $days_interval = 7;

                break;

            case 'monthly':
                $days_interval = 30;

                break;
        }

        /* Get potential monitors from users that have almost all the conditions to get an email report right now */
        $result = database()->query("
            SELECT
                `monitors`.`monitor_id`,
                `monitors`.`name`,
                `monitors`.`email_reports_last_datetime`,
                `users`.`user_id`,
                `users`.`email`,
                `users`.`plan_settings`,
                `users`.`language`
            FROM 
                `monitors`
            LEFT JOIN 
                `users` ON `monitors`.`user_id` = `users`.`user_id` 
            WHERE 
                `users`.`active` = 1
                AND `monitors`.`is_enabled` = 1 
                AND `monitors`.`email_reports_is_enabled` = 1
				AND DATE_ADD(`monitors`.`email_reports_last_datetime`, INTERVAL {$days_interval} DAY) <= '{$date}'
            LIMIT 25
        ");

        /* Go through each result */
        while($row = $result->fetch_object()) {
            $row->plan_settings = json_decode($row->plan_settings);

            /* Make sure the plan still lets the user get email reports */
            if(!$row->plan_settings->email_reports_is_enabled) {
                db()->where('monitor_id', $row->monitor_id)->update('monitors', ['email_reports_is_enabled' => 0]);

                continue;
            }

            /* Prepare */
            $start_date = (new \DateTime())->modify('-' . $days_interval . ' days')->format('Y-m-d H:i:s');

            /* Monitor logs */
            $monitor_logs = [];

            $monitor_logs_result = database()->query("
                SELECT 
                    `is_ok`,
                    `response_time`,
                    `datetime`
                FROM 
                    `monitors_logs`
                WHERE 
                    `monitor_id` = {$row->monitor_id} 
                    AND (`datetime` BETWEEN '{$start_date}' AND '{$date}')
            ");

            $total_ok_checks = 0;
            $total_not_ok_checks = 0;
            $total_response_time = 0;

            while($monitor_log = $monitor_logs_result->fetch_object()) {
                $monitor_logs[] = $monitor_log;

                $total_ok_checks = $monitor_log->is_ok ? $total_ok_checks + 1 : $total_ok_checks;
                $total_not_ok_checks = !$monitor_log->is_ok ? $total_not_ok_checks + 1 : $total_not_ok_checks;
                $total_response_time += $monitor_log->response_time;
            }

            /* Monitor incidents */
            $monitor_incidents = [];

            $monitor_incidents_result = database()->query("
                SELECT 
                    `start_datetime`,
                    `end_datetime`
                FROM 
                    `incidents`
                WHERE 
                    `monitor_id` = {$row->monitor_id} 
                    AND `start_datetime` >= '{$start_date}' 
                    AND `end_datetime` <= '{$date}'
            ");

            while($monitor_incident = $monitor_incidents_result->fetch_object()) {
                $monitor_incidents[] = $monitor_incident;
            }

            /* calculate some data */
            $total_monitor_logs = count($monitor_logs);
            $uptime = $total_ok_checks > 0 ? $total_ok_checks / ($total_ok_checks + $total_not_ok_checks) * 100 : 0;
            $downtime = 100 - $uptime;
            $average_response_time = $total_ok_checks > 0 ? $total_response_time / $total_ok_checks : 0;

            /* Get the language for the user */
            $language = language($row->language);

            /* Prepare the email title */
            $email_title = sprintf(
                $language->cron->monitor_email_report->title,
                $row->name,
                \Altum\Date::get($start_date, 5),
                \Altum\Date::get('', 5)
            );

            /* Prepare the View for the email content */
            $data = [
                'row'                       => $row,
                'language'                  => $language,
                'monitor_logs'              => $monitor_logs,
                'total_monitor_logs'        => $total_monitor_logs,
                'monitor_logs_data' => [
                    'uptime'                => $uptime,
                    'downtime'              => $downtime,
                    'average_response_time' => $average_response_time,
                    'total_ok_checks'       => $total_ok_checks,
                    'total_not_ok_checks'   => $total_not_ok_checks
                ],
                'monitor_incidents'         => $monitor_incidents,

                'start_date'                => $start_date,
                'end_date'                  => $date
            ];

            $email_content = (new \Altum\Views\View('partials/cron/monitor_email_report', (array) $this))->run($data);

            /* Send the email */
            send_mail($row->email, $email_title, $email_content);

            /* Update the store */
            db()->where('monitor_id', $row->monitor_id)->update('monitors', ['email_reports_last_datetime' => $date]);

            /* Insert email log */
            db()->insert('email_reports', ['user_id' => $row->user_id, 'monitor_id' => $row->monitor_id, 'datetime' => $date]);

            if(DEBUG) {
                echo sprintf('Email sent for user_id %s and monitor_id %s', $row->user_id, $row->monitor_id);
            }
        }

    }

    public function heartbeats_email_reports() {

        $this->initiate();

        /* Only run this part if the email reports are enabled */
        if(!settings()->monitors_heartbeats->email_reports_is_enabled) {
            return;
        }

        $date = \Altum\Date::$date;

        /* Determine the frequency of email reports */
        $days_interval = 7;

        switch(settings()->monitors_heartbeats->email_reports_is_enabled) {
            case 'weekly':
                $days_interval = 7;

                break;

            case 'monthly':
                $days_interval = 30;

                break;
        }

        /* Get potential heartbeats from users that have almost all the conditions to get an email report right now */
        $result = database()->query("
            SELECT
                `heartbeats`.`heartbeat_id`,
                `heartbeats`.`name`,
                `heartbeats`.`email_reports_last_datetime`,
                `users`.`user_id`,
                `users`.`email`,
                `users`.`plan_settings`,
                `users`.`language`
            FROM 
                `heartbeats`
            LEFT JOIN 
                `users` ON `heartbeats`.`user_id` = `users`.`user_id` 
            WHERE 
                `users`.`active` = 1
                AND `heartbeats`.`is_enabled` = 1 
                AND `heartbeats`.`email_reports_is_enabled` = 1
				AND DATE_ADD(`heartbeats`.`email_reports_last_datetime`, INTERVAL {$days_interval} DAY) <= '{$date}'
            LIMIT 25
        ");

        /* Go through each result */
        while($row = $result->fetch_object()) {
            $row->plan_settings = json_decode($row->plan_settings);

            /* Make sure the plan still lets the user get email reports */
            if(!$row->plan_settings->email_reports_is_enabled) {
                db()->where('heartbeat_id', $row->heartbeat_id)->update('heartbeats', ['email_reports_is_enabled' => 0]);

                continue;
            }

            /* Prepare */
            $start_date = (new \DateTime())->modify('-' . $days_interval . ' days')->format('Y-m-d H:i:s');

            /* Monitor logs */
            $heartbeat_logs = [];

            $heartbeat_logs_result = database()->query("
                SELECT 
                    `is_ok`,
                    `datetime`
                FROM 
                    `heartbeats_logs`
                WHERE 
                    `heartbeat_id` = {$row->heartbeat_id} 
                    AND (`datetime` BETWEEN '{$start_date}' AND '{$date}')
            ");

            $total_runs = 0;
            $total_missed_runs = 0;

            while($heartbeat_log = $heartbeat_logs_result->fetch_object()) {
                $heartbeat_logs[] = $heartbeat_log;

                $total_runs = $heartbeat_log->is_ok ? $total_runs + 1 : $total_runs;
                $total_missed_runs = !$heartbeat_log->is_ok ? $total_missed_runs + 1 : $total_missed_runs;
            }

            /* Monitor incidents */
            $heartbeat_incidents = [];

            $heartbeat_incidents_result = database()->query("
                SELECT 
                    `start_datetime`,
                    `end_datetime`
                FROM 
                    `incidents`
                WHERE 
                    `heartbeat_id` = {$row->heartbeat_id} 
                    AND `start_datetime` >= '{$start_date}' 
                    AND `end_datetime` <= '{$date}'
            ");

            while($heartbeat_incident = $heartbeat_incidents_result->fetch_object()) {
                $heartbeat_incidents[] = $heartbeat_incident;
            }

            /* calculate some data */
            $total_heartbeat_logs = count($heartbeat_logs);
            $uptime = $total_runs > 0 ? $total_runs / ($total_runs + $total_missed_runs) * 100 : 0;
            $downtime = 100 - $uptime;

            /* Get the language for the user */
            $language = language($row->language);

            /* Prepare the email title */
            $email_title = sprintf(
                $language->cron->heartbeat_email_report->title,
                $row->name,
                \Altum\Date::get($start_date, 5),
                \Altum\Date::get('', 5)
            );

            /* Prepare the View for the email content */
            $data = [
                'row'                       => $row,
                'language'                  => $language,
                'heartbeat_logs'            => $heartbeat_logs,
                'total_heartbeat_logs'      => $total_heartbeat_logs,
                'heartbeat_logs_data' => [
                    'uptime'                => $uptime,
                    'downtime'              => $downtime,
                    'total_runs'            => $total_runs,
                    'total_missed_runs'     => $total_missed_runs
                ],
                'heartbeat_incidents'       => $heartbeat_incidents,

                'start_date'                => $start_date,
                'end_date'                  => $date
            ];

            $email_content = (new \Altum\Views\View('partials/cron/heartbeat_email_report', (array) $this))->run($data);

            /* Send the email */
            send_mail($row->email, $email_title, $email_content);

            /* Update the store */
            db()->where('heartbeat_id', $row->heartbeat_id)->update('heartbeats', ['email_reports_last_datetime' => $date]);

            /* Insert email log */
            db()->insert('email_reports', ['user_id' => $row->user_id, 'heartbeat_id' => $row->heartbeat_id, 'datetime' => $date]);

            if(DEBUG) {
                echo sprintf('Email sent for user_id %s and heartbeat_id %s', $row->user_id, $row->heartbeat_id);
            }
        }

    }

}
