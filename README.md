# Inventario + Ventas Simple

Sistema web desarrollado en PHP para gestionar productos y registrar ventas, usando una arquitectura MVC ligera, localStorage para el inventario y Eloquent ORM para la persistencia de ventas en MySQL.

## Descripción

El proyecto cubre dos módulos principales:

- Productos: CRUD completo en el navegador con validaciones obligatorias.
- Ventas: registro de ventas conectado al inventario y persistencia en MySQL.

La aplicación combina frontend simple con JavaScript vanilla y backend PHP con Eloquent ORM, manteniendo una estructura clara por capas.

## Funcionalidades implementadas

- Crear, listar, editar y eliminar productos.
- Validar nombre obligatorio.
- Validar stock mayor o igual a 0.
- Validar precio mayor a 0.
- Mostrar métricas del inventario.
- Registrar ventas con validaciones de stock.
- Persistir ventas en MySQL.
- Descontar stock del inventario tras registrar una venta.
- Proteger el formulario de ventas con CSRF.

## Tecnologías

- PHP 8.3
- Composer
- Eloquent ORM
- MySQL 8
- Docker Compose para la base de datos
- JavaScript vanilla
- localStorage

## Estructura del proyecto

```text
ecotec-programacion-web-integradora-2/
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── database/
│   └── inventario.sql
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── index.php
├── composer.json
├── composer.lock
├── docker-compose.yml
└── README.md
```

## Requisitos

- PHP 8.2 o superior
- Composer
- Docker Desktop o motor Docker disponible
- Navegador moderno

## Instalación

### 1. Instalar dependencias PHP

```bash
composer install
```

### 2. Levantar solo MySQL con Docker Compose

```bash
docker compose up -d
```

La base se expone en el puerto 3307 para evitar conflicto con MySQL local.

### 3. Ejecutar el servidor local de PHP

Puedes hacerlo directamente con Composer:

```bash
composer servidor
```

O con PHP:

```bash
php -S localhost:8000 -t public
```

### 4. Abrir el sistema en el navegador

```text
http://localhost:8000
```

## Configuración de base de datos

El proyecto versiona el archivo [.env](.env) para simplificar esta entrega académica.

Parámetros actuales:

```text
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=inventario_ventas
DB_USERNAME=inventario_user
DB_PASSWORD=inventario_pass
```

## Script SQL

El archivo [database/inventario.sql](database/inventario.sql) crea la tabla de ventas y se monta automáticamente en el contenedor MySQL.

## Usuario de prueba

No aplica. El sistema no requiere autenticación.

## Capturas sugeridas para la entrega

- Pantalla de inicio
- Módulo de productos con registros creados
- Módulo de ventas con historial visible
- Contenedor MySQL levantado

## Commits actuales del trabajo

1. initial: crear base del proyecto con Docker y Eloquent ORM
2. feat: agregar estructura MVC y navegación base
3. chore: eliminar docker y ajustar entorno local
4. chore: restaurar mysql en docker compose
5. chore: trackear env y ajustar arranque local
6. feat: implementar productos y ventas funcionales

## Nota académica

Este proyecto fue adaptado para una entrega universitaria, priorizando claridad, facilidad de ejecución local y separación básica de responsabilidades.
