# Installation / Déploiement

## Préparation de la machine

### 1. Mise à jour du système

Mettez à jour le système pour garantir que tous les paquets sont à jour :

```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Installation des dépendances nécessaires

Installez PHP, Nginx (ou Apache), et les extensions PHP requises pour Symfony :

```bash
sudo apt install -y nginx php8.4-fpm php8.4-cli php8.4-mysql php8.4-xml php8.4-mbstring php8.4-curl php8.4-intl php8.4-zip git unzip
```

### 3. Installation de Composer

Installez Composer (si ce n'est pas déjà fait) :

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

Vérifiez l'installation :

```bash
composer --version
```

### 4. Installation de Node.js et npm

Installez Node.js et npm pour la gestion des assets :

```bash
# Installation de Node.js via NodeSource
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs

# Vérification des installations
node --version
npm --version
```

### 5. Installation de MariaDB

Si MariaDB n'est pas déjà installé :

```bash
sudo apt install mariadb-server mariadb-client
```

Sécurisez l'installation de MariaDB :

```bash
sudo mysql_secure_installation
```

Créez un utilisateur et une base de données pour votre projet :

```bash
sudo mysql -u root -p
```

Dans la console MariaDB :

```sql
CREATE DATABASE nom_de_votre_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'symfony_user'@'localhost' IDENTIFIED BY 'mot_de_passe_securise';
GRANT ALL PRIVILEGES ON nom_de_votre_base.* TO 'symfony_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## Installation du projet

### 1. Clonage du projet Symfony

Clonez votre projet depuis le dépôt Git :

```bash
git clone https://votre-dépôt.git nom-du-projet
cd nom-du-projet
```

### 2. Installation des dépendances PHP

Installez les dépendances PHP avec Composer :

```bash
composer install --no-dev --optimize-autoloader
```

### 3. Installation des dépendances front-end (React)

Installez les dépendances Node.js et génération des assets :

```bash
npm install
npm run build
```

### 4. Configuration de l'environnement (.env)

Copiez et configurez le fichier d'environnement :

```bash
cp .env .env.local
```

Configurez au minimum :

- `APP_ENV=prod`
- `DATABASE_URL=mysql://symfony_user:mot_de_passe_securise@127.0.0.1:3306/nom_de_votre_base?serverVersion=mariadb-10.6.22&charset=utf8mb4`
- `MAILER_DSN=smtp://localhost:1025`

Éditez le fichier `.env.local` avec vos paramètres :

```bash
nano .env.local
```

### 5. Configuration de la base de données

Créez la base de données et exécutez les migrations :

```bash
# Création de la base de données
php bin/console doctrine:database:create

# Exécution des migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Chargement des fixtures
php bin/console doctrine:fixtures:load --no-interaction
```

### 6. Configuration JWT

Générez les clés de chiffrement :

```bash
# Génération des clés JWT
php bin/console lexik:jwt:generate-keypair

# Vérifier la configuration JWT
php bin/console lexik:jwt:check-config
```

### 7. Configuration des permissions

Définissez les bonnes permissions pour les dossiers de cache, logs et JWT :

```bash
sudo chown -R www-data:www-data var/ config/jwt/
sudo chmod -R 775 var/
sudo chmod 600 config/jwt/private.pem
sudo chmod 644 config/jwt/public.pem
```

## Configuration HTTPS avec Let's Encrypt et Nginx

### 1. Installation de Certbot

Installez Certbot pour obtenir et gérer les certificats SSL :

```bash
sudo apt install snapd
sudo snap install core; sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

### 2. Obtention du certificat SSL

Obtenez un certificat SSL pour votre domaine :

```bash
sudo certbot --nginx -d votre-domaine.com -d www.votre-domaine.com
```

Pour un certificat uniquement (sans configuration automatique Nginx) :

```bash
sudo certbot certonly --nginx -d votre-domaine.com -d www.votre-domaine.com
```

### 3. Configuration Nginx avec HTTPS

Mettez à jour votre configuration Nginx pour inclure HTTPS :

```bash
sudo nano /etc/nginx/sites-available/votre-projet
```

Configuration complète avec HTTPS :

```nginx
# Redirection HTTP vers HTTPS
server {
    listen 80;
    server_name votre-domaine.com www.votre-domaine.com;
    return 301 https://$server_name$request_uri;
}

# Configuration HTTPS
server {
    listen 443 ssl http2;
    server_name votre-domaine.com www.votre-domaine.com;
    root /chemin/vers/votre-projet/public;
    index index.php;

    # Certificats SSL
    ssl_certificate /etc/letsencrypt/live/votre-domaine.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/votre-domaine.com/privkey.pem;

    # Configuration SSL moderne
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_timeout 10m;
    ssl_session_cache shared:SSL:10m;
    ssl_session_tickets off;

    # Headers de sécurité
    add_header Strict-Transport-Security "max-age=63072000" always;
    add_header X-Frame-Options DENY always;
    add_header X-Content-Type-Options nosniff always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_param HTTPS on;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    # Optimisations pour les assets statiques
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        add_header Vary Accept-Encoding;
        access_log off;
    }

    error_log /var/log/nginx/projet_error.log;
    access_log /var/log/nginx/projet_access.log;
}
```

### 4. Test et rechargement de Nginx

Testez la configuration et rechargez Nginx :

```bash
sudo nginx -t
sudo systemctl reload nginx
```

### 5. Renouvellement automatique des certificats

Testez le renouvellement automatique :

```bash
sudo certbot renew --dry-run
```

Le renouvellement automatique est configuré par défaut. Vérifiez avec :

```bash
sudo systemctl list-timers | grep certbot
```

## Mise à jour du projet

Pour les futures mises à jour :

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:clear --env=prod
```
