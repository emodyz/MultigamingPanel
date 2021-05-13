#!/bin/sh -e

case $1 in

  web_server)
    YOUR WEB SERVER COMMAND
  ;;

  cron_jobs)
     exec crond -f
  ;;

  *)
    exec "$@"
  ;;

esac

exit 0
