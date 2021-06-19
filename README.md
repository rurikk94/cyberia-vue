# Cyberia - **SISTEMA WEB DE GESTIÓN DE TRABAJOS**

## Requerimientos Previos

El sistema requiere sistema operativo Windows o Linux

Requiere los programas [Composer](https://getcomposer.org/download/) y [Node.js](https://nodejs.org/en/)

También requiere base de datos MariaDB 10.4 o MySql 5.7

Además, servidor web apache 2.4 y PHP 7.3

El sistema utiliza el framework Laravel 8.4

## Instrucciones de instalación

Para la instalación deberá:

- Descomprimir el archivo

- Crear una base de datos en el servidor de base de datos

- Configurar el host del sistema operativo con un host a preferencia a utilizar en el sistema

- Configurar el servidor web apache con el dominio indicado en el host apuntando a la carpeta donde fue descomprimido el archivo

- Configurar el archivo .env.example del proyecto con los datos de conexión a la bd y del servidor de email  y indicar en APP_URL el host a utilizar

- Renombrar el archivo .env.example por .env

- Ejecutar los siguientes comandos (en el mismo orden) en la carpeta raiz del proyecto para instalar las dependencias necesarias y configuraciones necesarias

  `composer install`
  `npm install`
  `php artisan storage:link`
  `php artisan migrate`
  `npm run production`
  
- ingresar a la web indicada como host y registrarse

### Repositorio

El código está hosteado en la siguiente página.

[rurikk94/cyberia-vue (github.com)](https://github.com/rurikk94/cyberia-vue)