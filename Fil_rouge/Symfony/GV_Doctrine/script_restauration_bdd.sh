#!/bin/bash

# Script de sauvegarde/restauration de la base green_village

DB_USER="Afpa"
DB_NAME="green_village"
BACKUP_FILE="save_green_village.sql"

case "$1" in
  save)
    echo "==> Sauvegarde de la base $DB_NAME..."
    mysqldump -u $DB_USER -p $DB_NAME > $BACKUP_FILE
    echo "Sauvegarde terminée : $BACKUP_FILE"
    ;;
    
  restore)
    echo "==> Restauration de la base $DB_NAME..."
    mysql -u $DB_USER -p -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME;"
    mysql -u $DB_USER -p $DB_NAME < $BACKUP_FILE
    echo "Restauration terminée."
    ;;

  *)
    echo "Usage: $0 {save|restore}"
    ;;
esac
