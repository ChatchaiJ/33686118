#!/bin/sh

DB="p33686118"
echo "drop database $DB" | mysql
cat create-db.sql | mysql
