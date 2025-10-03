<?php



// $databases['default']['default'] = [
//     'database' => $_ENV['MYSQL_DATABASE'],
//     'driver' => 'mysql',
//     'host' => $_ENV['MYSQL_HOSTNAME'],
//     'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
//     'password' => $_ENV['MYSQL_PASSWORD'],
//     'port' => $_ENV['MYSQL_PORT'],
//     'prefix' => '',
//     'username' => $_ENV['MYSQL_USER'],
//     // 'pdo' => [
//     //     PDO::MYSQL_ATTR_SSL_CA => '/var/www/car.crt',
//     // ],
//     'isolation_level' => 'READ COMMITTED',
// ];

$databases['default']['default'] = [
    'driver' => 'mysql',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'database' => $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE'),
    'username' => $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER'),
    'password' => $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD'),
    'host' => $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST'),
    'port' => $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT'),
    'prefix' => '',
    'isolation_level' => 'READ COMMITTED',
];



$settings['hash_salt'] = $_ENV['HASH_SALT'] ?? getenv('HASH_SALT');



if (empty($settings['config_sync_directory'])) {
    $settings['config_sync_directory'] = 'sites/default/files/sync';
}


$settings['skip_permissions_hardening'] = TRUE;



$settings['update_free_access'] = FALSE;


$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

$settings['trusted_host_patterns'] = [
    '^penzest\.dev$',
    '^www\.penzest\.dev$',
];


$settings['file_scan_ignore_directories'] = [
    'node_modules',
    'bower_components',
];

/**
 * The default number of entities to update in a batch process.
 *
 * This is used by update and post-update functions that need to go through and
 * change all the entities on a site, so it is useful to increase this number
 * if your hosting configuration (i.e. RAM allocation, CPU speed) allows for a
 * larger number of entities to be processed in a single batch run.
 */
$settings['entity_update_batch_size'] = 50;

/**
 * Entity update backup.
 *
 * This is used to inform the entity storage handler that the backup tables as
 * well as the original entity type and field storage definitions should be
 * retained after a successful entity update process.
 */
$settings['entity_update_backup'] = TRUE;

/**
 * State caching.
 *
 * State caching uses the cache collector pattern to cache all requested keys
 * from the state API in a single cache entry, which can greatly reduce the
 * amount of database queries. However, some sites may use state with a
 * lot of dynamic keys which could result in a very large cache.
 */
$settings['state_cache'] = TRUE;

/**
 * Node migration type.
 *
 * This is used to force the migration system to use the classic node migrations
 * instead of the default complete node migrations. The migration system will
 * use the classic node migration only if there are existing migrate_map tables
 * for the classic node migrations and they contain data. These tables may not
 * exist if you are developing custom migrations and do not want to use the
 * complete node migrations. Set this to TRUE to force the use of the classic
 * node migrations.
 */
$settings['migrate_node_migrate_type_classic'] = FALSE;
