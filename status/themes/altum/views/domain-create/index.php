<?php defined('ALTUMCODE') || die() ?>

<?php require THEME_PATH . 'views/partials/ads_header.php' ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <small>
            <ol class="custom-breadcrumbs">
                <li>
                    <a href="<?= url('domains') ?>"><?= language()->domains->breadcrumb ?></a><i class="fa fa-fw fa-angle-right"></i>
                </li>
                <li class="active" aria-current="page"><?= language()->domain_create->breadcrumb ?></li>
            </ol>
        </small>
    </nav>

    <?php $url = parse_url(SITE_URL); $host = $url['host'] . (strlen($url['path']) > 1 ? $url['path'] : null); ?>

    <h1 class="h4 text-truncate"><?= language()->domain_create->header ?></h1>
    <p class="text-muted mb-4"><?= sprintf(language()->domains->input->help, '<strong>' . $_SERVER['SERVER_ADDR'] . '</strong>', '<strong>' . $host . '</strong>') ?></p>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="host"><i class="fa fa-fw fa-globe fa-sm text-muted mr-1"></i> <?= language()->domains->input->host ?></label>
                    <input type="text" id="host" name="host" class="form-control <?= \Altum\Alerts::has_field_errors('host') ? 'is-invalid' : null ?>" value="" placeholder="<?= language()->domains->input->host_placeholder ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('host') ?>
                </div>

                <div class="form-group">
                    <label for="custom_index_url"><i class="fa fa-fw fa-sitemap fa-sm text-muted mr-1"></i> <?= language()->domains->input->custom_index_url ?></label>
                    <input type="text" id="custom_index_url" name="custom_index_url" class="form-control" value="" placeholder="<?= language()->domains->input->custom_index_url_placeholder ?>" />
                    <small class="form-text text-muted"><?= language()->domains->input->custom_index_url_help ?></small>
                </div>

                <div class="form-group">
                    <label for="custom_not_found_url"><i class="fa fa-fw fa-location-arrow fa-sm text-muted mr-1"></i> <?= language()->domains->input->custom_not_found_url ?></label>
                    <input type="text" id="custom_not_found_url" name="custom_not_found_url" class="form-control" value="" placeholder="<?= language()->domains->input->custom_not_found_url_placeholder ?>" />
                    <small class="form-text text-muted"><?= language()->domains->input->custom_not_found_url_help ?></small>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary mt-3"><?= language()->global->create ?></button>
            </form>

        </div>
    </div>

</div>
