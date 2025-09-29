<?php



if (getenv('IS_DDEV_PROJECT') == 'true' && file_exists(__DIR__ . '/settings.ddev.php')) {
    include __DIR__ . '/settings.ddev.php';
}


if (getenv('IS_JAPACHRONICLES_PROJECT') == 'true' && file_exists(__DIR__ . '/settings.japs.php')) {
    include __DIR__ . '/settings.japs.php';
}
