-- Active: 1745306493697@@127.0.0.1@3306@GesCom
DROP USER 'util1'@'%';
CREATE USER 'util1'@'%' IDENTIFIED BY 'mot_de_passe';
GRANT ALL PRIVILEGES ON gescom.* TO 'util1'@'%';

-- ----------

DROP USER 'util2'@'%';
CREATE USER 'util2'@'%' IDENTIFIED BY 'mot_de_passe';
GRANT SELECT ON gescom.* TO 'util2'@'%';

-- ----------

DROP USER 'util3'@'%';
CREATE USER 'util3'@'%' IDENTIFIED BY 'mot_de_passe';
GRANT SELECT ON GesCom.customers TO 'util3'@'%';

-- FLUSH PRIVILEGES;