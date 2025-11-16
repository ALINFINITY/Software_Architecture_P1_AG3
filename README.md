<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Microservicio - Laravel 12

# Autores:

- Quilumbaquin Pillisa Alan David (ProgramadorL)
- Borja Díaz Adriana Maribel (adryborja95)
- Acurio Vasco Andres Acurio (andy031002)
- Fajardo Cueva Margarita Carina (MFajardo2812)
- Ojeda Tello Amy Lizett (amyyy03)
- Galo Wladyir Escobar Yela (wladyes)

## Descripción General

Este proyecto implementa un **microservicio RESTful para la gestión de usuarios** utilizando **Laravel 12.37.0**, siguiendo el patrón **MVC (Modelo–Vista–Controlador)** y el enfoque **API First**.
Está diseñado para ser **escalable horizontalmente**, ejecutándose en **múltiples instancias** sin compartir estado, y utiliza **Laravel Sanctum** para la autenticación basada en tokens personales.

El sistema devuelve **todas las respuestas en formato JSON**, incluye **validaciones de entrada**, y expone endpoints CRUD seguros y estandarizados.

# Instalación y Uso

### Usuarios externos con permisos en el repositorio

`vdcriollo@espe.edu.ec` 

### 1. Clonar el repositorio

`
    git clone https://github.com/ALINFINITY/Software_Architecture_P1_AG2.git  
    cd Software_Architecture_P1_AG2
`
### 2. Instalar dependencias
`
    composer install
`

### 3. Configurar el entorno
`
    cp .env.example .env
    Editar el archivo .env con los parámetros correspondientes:
`

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=app_usuarios_sfa
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
`
### 4. Generar la clave de la aplicación
`
    php artisan key:generate
`

### 5. Ejecutar las migraciones
`
    php artisan migrate
`

### 6. Desplegar el servicio
`
    php artisan serve
`

# License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

