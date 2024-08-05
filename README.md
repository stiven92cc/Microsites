<p align="center">
  <h2 align="center">Microsites</h2>
</p>

<!-- TABLE OF CONTENTS -->
## Tabla de contenido

* [Sobre el proyecto](#sobre-el-proyecto)
* [Construido con](#construido-con)
* [Prerequisitos](#prerequisitos)
* [Instalación](#instalación)
* [Configuración](#configuración)
* [Despliegue](#despliegue)
* [Comandos adicionales](#comandos-adicionales)

## Sobre el proyecto

Descripción breve del proyecto Microsites, su propósito y funcionalidad principal.

## Construido con

* [Laravel 11](https://laravel.com)
* [VueJS](https://vuejs.org/)
* [Vite](https://vitejs.dev/)

## Prerequisitos

Antes de comenzar, asegúrate de tener instaladas las siguientes herramientas:

* [MySQL](https://www.mysql.com/)
* [PHP 8.2](https://www.php.net/)
* [phpMyAdmin](https://www.phpmyadmin.net/) (opcional)
* [Node.js 22](https://nodejs.org/es/)
* [Composer](https://getcomposer.org/)

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/stiven92cc/Microsites.git
   cd Microsites
   
2. Instalar dependencias del backend:
    ```bash
   composer install

3. Generar archivo .env para configuración de las variables de entorno:
   ```bash
    cp .env.example .env

4. Generar la llave de la aplicación:
    ```bash
    php artisan key:generate
   
5. Migraciones y alimentación de la base de datos:
    ```bash
    php artisan migrate --seed

6. Instalar dependencias del frontend y construir los assets:
    ```bash
    npm i
    npm run dev
    npm run prod

## Configuración

1. Configurar la base de datos en phpMyAdmin y en el archivo .env generado anteriormente.

2. Configurar las credenciales de Mailtrap en el archivo .env para probar la funcionalidad de verificación de email del usuario.

3. Configurar los datos de la pasarela de pagos en el archivo .env. Las variables necesarias para la pasarela de pagos PlacetoPay son:
   ```env
   PLACETOPAY_LOGIN=
   PLACETOPAY_TRANKEY=
   PLACETOPAY_BASE_URL=
   
 4. El usuario administrador por defecto es:
    Email: admin@microsites.com
    Contraseña: password 

## Despliegue

1. Para desplegar la aplicación localmente, ejecuta:
    ```bash
   php artisan serve

## Comandos adicionales

1. Para resolver las transacciones, utiliza el siguiente comando:
    ```bash
    php artisan app:resolve-transactions
