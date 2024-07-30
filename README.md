# Orange Box API

## Descripción

Orange Box API es una aplicación backend desarrollada en Laravel, que proporciona endpoints para la gestión de productos y proveedores.

## Requisitos Previos

- Docker y Docker Compose

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/Alfaro-dev/doctor-lenguaje-api.git
   cd orange-box-backend
   ```

2. Copiar el archivo de configuración de ejemplo y configurar las variables de entorno:
   ```bash
   cp .env.example .env
   ```

3. Configurar las variables de entorno en el archivo `.env`:
   ```dotenv
   DB_CONNECTION=pgsql
   DB_HOST=pgsql
   DB_PORT=5432
   DB_DATABASE=nombre_de_tu_base_de_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

4. Iniciar Docker Sail:
   ```bash
   ./vendor/bin/sail up -d
   ```
   
5. Ejecutar las migraciones y seeders para crear las tablas y datos de ejemplo:
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

## Endpoints de la API

### Productos

- `GET /products`: Obtener todos los productos.
- `GET /products/{id}`: Obtener un producto por su ID.
- `POST /products`: Crear un nuevo producto.
- `PUT /products/{id}`: Actualizar un producto existente.
- `DELETE /products/{id}`: Eliminar un producto.

### Proveedores

- `GET /providers`: Obtener todos los proveedores.
- `GET /providers/{id}`: Obtener un proveedor por su ID.
- `POST /providers`: Crear un nuevo proveedor.
- `PUT /providers/{id}`: Actualizar un proveedor existente.
- `DELETE /providers/{id}`: Eliminar un proveedor.

## Uso de Postman

1. Importar la colección de Postman proporcionada en el archivo `Orange Box Api.postman_collection`.
2. Asegurarse de que la URL base esté configurada correctamente según el entorno de desarrollo.

## Despliegue

El proyecto ha sido desplegado exitosamente en Render y puede ser accedido en la siguiente URL:

[Orange Box API](https://orange-box-api.onrender.com)

## Estructura del Proyecto

```
orange-box-backend/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── data/
│   │   ├── products.json
│   │   └── providers.json
├── public/
├── resources/
├── routes/
│   ├── api.php
├── storage/
├── tests/
├── docker-compose.yml
├── .env.example
└── README.md
```
