# API REST para Gestión de Películas

Este proyecto es una API REST desarrollada en Laravel que permite realizar operaciones CRUD (Crear, Leer, Actualizar, Borrar) sobre datos de películas. La API proporciona endpoints para consultar, crear, editar y borrar películas, así como también para manejar imágenes asociadas a las películas.

## Requisitos

- PHP >= 8.2
- Composer
- Laravel >= 11.0
- Docker (engine y compose)

## Instalación

1. Clonar este repositorio en tu máquina local:

    ```bash
    git clone <https://github.com/teamq-ec/teamq-aplicacion-senior-laravel-david-guerra>
    ```

2. Configurar el archivo `.env` con los detalles del entorno de desarrollo

3. Ubicarse en el directorio raíz y ejecutar el comando para construir y levantar el contenedor:

    ```bash
    docker-compose up --build
    ```

4. Ejecutar las migraciones para crear las tablas en la base de datos:

    ```bash
    php artisan migrate
    ```

5. Para cargar datos de películas, ejecutar la semilla:

    ```bash
    php artisan db:seed --class=MovieSeeder
    ```
5. Para cargar datos del usuario administrador, ejecutar la semilla:

    ```bash
    php artisan db:seed --class=UsuarioSeeder
    ```

## Uso

### Endpoints Disponibles

- **GET /api/movies**: Obtener todas las películas.
    - Se ha configurado una paginación de 10 items por página.
    - Se han implementado los siguientes filtros:
        - director
        - genre
        - year_min
        - year_max
    - Ejemplo de como usar un filtro de género: **/api/movies?genre=Comedy**
- **GET /api/movies/{id}**: Obtener una película por su ID.
- **POST /api/movies**: Crear una nueva película.
- **PATCH /api/movies/{id}**: Actualizar parcialmente una película existente.
- **PUT /api/movies/{id}**: Actualizar totalmente una película existente.
- **DELETE /api/movies/{id}**: Borrar una película existente.
- **POST /api/movies/{id}/imagen**: Subir una imagen para una película.
- **GET /api/movies/{id}/imagen**: Obtener la imagen asociada a una película.
- **GET /api/users/**: Obtener todos los usuarios.
- **GET /api/users/{id}**: Obtener un usuario por su ID.
- **POST /api/users**: Crear un nuevo usuario.
- **PUT /api/users/{id}**: Actualizar un usuario existente.
- **DELETE /api/users/{id}**: Borrar un usuario existente.

### Estructura de datos

La estructura para administrar las películas es la siguiente:

```bash
{
    "title": "Película de Prueba",
    "genre": "Género de Prueba",
    "description": "Descripción de Prueba",
    "director": "Director de Prueba",
    "year": 2024
}
```

La estructura para administrar los usuarios es la siguiente:

```bash
{
    "name": "Nombre de Prueba",
    "email": "Email de Prueba",
    "password": "Password de Prueba",
    "role": "user"
}
```

### Autenticación

La API utiliza autenticación basada en tokens utilizando Laravel Sanctum. Se debe autenticar para acceder a los endpoints protegidos. Para obtener un token de autenticación, se debe enviar una solicitud POST al endpoint `/login` con las credenciales de usuario asignadas.

### Documentación de la API

La documentación de la API está disponible en la ruta `/docs`. Se puede utilizar esta documentación para explorar los endpoints disponibles y probarlos directamente desde el navegador.

## Ejemplos

Aquí se tiene algunos ejemplos de cómo interactuar con la API utilizando cURL:

### Obtener Todas las Películas

```bash
curl http://localhost:8000/api/movies
```
### Agregar una Nueva Película

```bash
curl -X POST \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {TU_TOKEN}" \
  -d '{"title":"Nueva Película", "genre": "Nuevo Género", "description": "Nueva Descripción", "director":"Director Ejemplo", "year":2023}' \
  http://localhost:8000/api/movies
```