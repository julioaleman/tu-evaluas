# Guía de instalación de Tú evaúas 3.0

# Requerimientos técnicos:
PHP >= 5.5.9 
Mysql
Composer
Bower
nodejs

1: copiar los archivos del siguiente repositorio:
[github] (https://github.com/GobiernoFacil/tu-evaluas.git)

2: en la carpeta raíz, hay que correr el siguiente comando:
```bash
composer install
```

3: en la carpeta raíz, hay que copiar el archivo .env.example a .env
```bash
cp .env.example .env
```

4: crear la base de datos que se va a ocupar

5: editar el archivo .env, en el que se debe poner la información de conexión a la DB, la información del api  de mailgun, en caso de que se quiera enviar correos, y definir en APP_URL el host

aquí un ejemplo del archivo .env:
```bash
APP_ENV=local
APP_DEBUG=true
APP_KEY=somerandomkey

DB_HOST=http://plataformadetransparencia.org.mx
DB_DATABASE=thedb
DB_USERNAME=thedbuser
DB_PASSWORD=thedbpass

APP_URL=http://plataformadetransparencia.org.mx

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
 
MAIL_DRIVER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@plataformadetransparencia.org.mx
MAIL_PASSWORD=themailgunpass
MAIL_ENCRYPTION=null

MAILGUN_DOMAIN=themailgundomain
MAILGUN_KEY=key-themailginkey
MAILGUN_SECRET=key-themailgunsecret
```
 
6: Despues de guardar y cerrar el archivo .env, hay que generar la llave de encriptación con:
```bash
php artisan key:generate
```

7: Acto siguiente, hay que crear las tablas en la base de datos, con el siguiente comando:
```bash
php artisan migrate
```

8: hay que copiar la info de municipios y localidadespara las preguntas de ubicación
```bash
php artisan db:seed
```

9: hay que descargar las librerías de Javascript necesarias. Dentro de la carpeta de public/js, hay que ejecutar el siguiente comando:
```bash
bower install
```

y eso es todo amigos!
