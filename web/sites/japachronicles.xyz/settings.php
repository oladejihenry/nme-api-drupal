<?php


$databases['default']['default'] = [
    'database' => $_ENV['JAPACHRONICLES_MYSQL_DATABASE'],
    'driver' => 'mysql',
    'host' => $_ENV['JAPACHRONICLES_MYSQL_HOSTNAME'],
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'password' => $_ENV['JAPACHRONICLES_MYSQL_PASSWORD'],
    'port' => $_ENV['JAPACHRONICLES_MYSQL_PORT'],
    'prefix' => '',
    'username' => $_ENV['JAPACHRONICLES_MYSQL_USER'],
    'pdo' => [
        PDO::MYSQL_ATTR_SSL_CA => '/var/www/japs.crt',
    ],
    'isolation_level' => 'READ COMMITTED',
];


$settings['hash_salt'] = $_ENV['JAPACHRONICLES_HASH_SALT'];



// if (empty($settings['config_sync_directory'])) {
//     $settings['config_sync_directory'] = '../config/sync/japachronicles.xyz';
// }


$settings['skip_permissions_hardening'] = TRUE;
$settings['trusted_host_patterns'] = [
    '^japachronicles\.xyz$',
    '^www\.japachronicles\.xyz$',
];


$settings['file_scan_ignore_directories'] = [
    'node_modules',
    'bower_components',
];


$settings['entity_update_batch_size'] = 50;


$settings['entity_update_backup'] = TRUE;


$settings['state_cache'] = TRUE;


$settings['migrate_node_migrate_type_classic'] = FALSE;
