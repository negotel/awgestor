<?php
include_once dirname(dirname(__FILE__))."/settings.php";
/**
 * @param string $path
 * @return string
 */
function url($path = null)
{

    $path_url = (strpos($_SERVER['HTTP_HOST'], "localhost")) ? SET_URL_TEST : SET_URL_PRODUCTION;
    if ($path) {
        return "{$path_url}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return SET_URL_PRODUCTION;
}