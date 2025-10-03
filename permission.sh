#!/bin/bash

# Ensure required directories exist
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

# Ensure ownership (Railway user)
chown -R $(whoami):$(whoami) web/sites/default/files

# Set permissions
chmod -R 775 web/sites/default/files
chmod 444 web/sites/default/settings.php

# Import config if YAML files exist
if [ -n "$(ls -A web/sites/default/files/sync/*.yml 2>/dev/null)" ]; then
  ./vendor/bin/drush config:import -y
fi

# Clear cache (CSS/JS aggregation happens automatically)
./vendor/bin/drush cr
