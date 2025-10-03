#!/bin/bash

# Ensure all required directories exist
DIRS=(
  web/sites/default/files
  web/sites/default/files/private
  web/sites/default/files/tmp
  web/sites/default/files/sync
  web/sites/default/files/css
  web/sites/default/files/js
)

for dir in "${DIRS[@]}"; do
  mkdir -p "$dir"
done

# Set permissions recursively
chmod -R 775 web/sites/default/files

chmod 444 web/sites/default/settings.php

# Clear Drupal caches
./vendor/bin/drush config:import
./vendor/bin/drush cr


