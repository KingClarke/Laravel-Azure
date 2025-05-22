#!/bin/bash

# Start nginx with your custom config in the foreground (blocks and keeps container alive)
nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;"
