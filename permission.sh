#!/bin/bash

# Ensure all required directories exist
DIRS=(
  web/sites/default/files
  web/sites/default/files/private
  web/sites/default/files/tmp
  web/sites/default/files/sync
  web/sites/default/files/{css,js,php,temp}
)

for dir in "${DIRS[@]}"; do
  mkdir -p "$dir"
done

# Set permissions recursively
chmod -R 775 web/sites/default/files

# Clear Drupal caches
./vendor/bin/drush config:import
./vendor/bin/drush cr


