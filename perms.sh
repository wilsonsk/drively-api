#!/bin/bash
chown -R www-data:www-data *
chmod -R 550 *
find . -type d -name templates_c -exec chmod -R 770 {} \;
find . -type d -name temp -exec chmod -R 770 {} \;
find . -type d -name alt-images -exec chmod -R 755 {} \;
find . -type d -name page-images -exec chmod -R 755 {} \;
find . -type d -name files -exec chmod -R 660 {} \;
find . -type d -name docs -exec chmod -R 660 {} \;
find . -type d -name documents -exec chmod -R 660 {} \;
find . -type d -name forms -exec chmod -R 660 {} \;
find . -type d -name Setup -exec chmod -R 660 {} \;
