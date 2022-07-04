#!/bin/sh -e
  exec crond -b -L /dev/stdout
exit 0
