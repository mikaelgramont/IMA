#!/bin/bash

# This script will be run from a cron job and logs should be directed to ../logs
# through a cron entry looking like:
# Every hour at 1 minute past the hour.
# 1 * * * * /home/IMA/bin/curlscript.sh > /home/IMA/logs/cron.log
# This means the logs folder needs to be writable by the cron user.
curl https://www.mountainboardworld.org/perform-update?type=events-cron
