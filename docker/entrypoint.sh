#!/bin/bash

echo "Migrate"
php /opt/www/bin/hyperf.php migrate

echo "Starting my application..."
php /opt/www/bin/hyperf.php start
