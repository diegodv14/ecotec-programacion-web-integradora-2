# Inventario + Ventas Simple

Aplicación web en PHP para administrar productos y registrar ventas en una interfaz sencilla. El módulo de productos funciona con localStorage y el módulo de ventas guarda la información en MySQL usando Eloquent ORM.

## Descripción general

El sistema está dividido en dos áreas principales:

- Inventario de productos con operaciones de crear, editar, eliminar y listar.
- Registro de ventas con validación de stock y persistencia en base de datos.

La idea es mantener un flujo simple: primero se cargan productos, luego esos productos se usan en el formulario de ventas y, cuando una venta se registra correctamente, el stock también se actualiza en el navegador.

## Funcionalidades

- Crear productos.
- Listar productos.
- Editar productos.
- Eliminar productos.
- Validar nombre obligatorio.
- Validar stock mayor o igual a 0.
- Validar precio mayor a 0.
- Mostrar métricas del inventario y alertas de stock.
- Registrar ventas con validaciones del lado cliente y servidor.
- Guardar ventas en MySQL con Eloquent ORM.
- Descontar el stock del producto vendido en localStorage.
- Proteger el formulario de ventas con token CSRF.

## Tecnologías usadas

- PHP 8.3
- Composer
- Eloquent ORM
- MySQL 8
- Docker Compose para MySQL
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
│   ├── screenshots/
│   └── index.php
├── composer.json
├── composer.lock
├── docker-compose.yml
└── README.md
```

## Requisitos

- PHP 8.2 o superior
- Composer
- Docker disponible para levantar MySQL
- Navegador moderno

## Instalación y ejecución

### 1. Instalar dependencias PHP

```bash
composer install
```

### 2. Levantar MySQL con Docker Compose

```bash
docker compose up -d
```

La base se publica en el puerto 3307 para evitar conflictos con otras instalaciones locales de MySQL.

### 3. Ejecutar el servidor local de PHP

Puedes hacerlo directamente con PHP:

```bash
php -S localhost:8000 -t public
```

También puedes usar el script de Composer definido en [composer.json](composer.json):

```bash
composer servidor
```

Si usas Composer para mantener el servidor levantado por mucho tiempo, puede ser mejor ejecutar PHP directamente para evitar el timeout por defecto de Composer.

### 4. Abrir la aplicación

```text
http://localhost:8000
```

## Configuración de base de datos

La conexión actual usa estos valores:

```text
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=inventario_ventas
DB_USERNAME=inventario_user
DB_PASSWORD=inventario_pass
```

## Base de datos

El archivo [database/inventario.sql](database/inventario.sql) crea la tabla ventas y se monta automáticamente en el contenedor MySQL al iniciar el servicio.

## Capturas

### Vista del módulo de ventas

<img src="public/screenshots/Captura%20de%20pantalla%202026-04-30%20191823.png" alt="Módulo de ventas" width="900">

### Registro guardado en la base de datos

<img src="public/screenshots/Captura%20de%20pantalla%202026-04-30%20191649.png" alt="Registro de ventas en MySQL" width="900">

## Notas de uso

- El módulo de productos depende de localStorage del navegador.
- El módulo de ventas toma los productos desde ese inventario local.
- Si no existen productos cargados, el formulario de ventas no tendrá opciones disponibles.

## Historial de commits

1. initial: crear base del proyecto con Docker y Eloquent ORM
2. feat: agregar estructura MVC y navegación base
3. chore: eliminar docker y ajustar entorno local
4. chore: restaurar mysql en docker compose
5. chore: trackear env y ajustar arranque local
6. feat: implementar productos y ventas funcionales
7. feat: implementar estilos de css
