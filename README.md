# CRUD en Laravel y Frontend en Vue

Este repositorio implementa un CRUD básico utilizando Laravel en el backend y Vue.js con Vite en el frontend. Este README proporciona instrucciones para configurar el entorno y ejecutar el proyecto.

## Requisitos previos

1. **PHP** >= 8.0
2. **Composer**
3. **laravel**
4. **Node.js** >= 22.12.0
5. **NPM**
6. **Base de datos** (MySQL)

---

## Script de la base de datos (Laravel):
1. El archivo database.sql se encuentra el script para poder crear la base de datos con sus tablas y relaciones
2. El archivo datos_ejemplo.sql es un script que inserta datos de ejemplo a la base de datos este no es necesario ejecutarlo si no quieres los datos de ejemplo
## Configuración del Backend (Laravel)

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/samescodev/prueba-tecnica-danny-sambrano.git
   cd prueba-tecnica-danny-sambrano
   ```
1. **Ingresa a la carpeta backend**:
   ```bash
   cd backend
   ```
2. **Instalar dependencias de Laravel**:
   ```bash
   composer install
   ```
 **Nota** si te da error esta parte vuelve a ejecutar el comando
3. **Configurar el archivo `.env`** en la carpeta backend:
   - Copia el archivo de ejemplo o crea un archivo nuevo .env y compia lo que hay en .env.example:
     ```bash
     cp .env.example .env
     ```
   - Configura las variables de entorno para la base de datos:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1 #coloca el host de tu base de datos
     DB_PORT=3306 #coloca el puerto
     DB_DATABASE=prueba_tecnica #el script de sql crea una base de datos prueba_tecnica, pero puedes cambiar si usas otra
     DB_USERNAME=usuario #escribe el usuario
     DB_PASSWORD=contraseña #escribe la contraseña
     ```

5. **Generar la clave de la aplicación**:
   ```bash
   php artisan key:generate
   ```

6. **Migrar y sembrar la base de datos**:
   - Las migraciones no estan configuradas, así que se requiere de ejecutar el script database.sql y datos_ejemplo.sql antes de levantar el backend

7. **Iniciar el servidor de desarrollo**:
   ```bash
   php artisan serve
   ```

Por defecto el backend estará disponible en `http://localhost:8000`.

---

## Configuración del Frontend (Vue + Vite)

1. **Abre otra terminal y navega al directorio del frontend**:
   ```bash
   cd frontend
   ```

2. **Instalar dependencias del frontend**:
   ```bash
   npm install
   ```

3. **Iniciar el servidor de desarrollo**:
   ```bash
   npm run serve
   ```

El frontend estará disponible en `http://localhost:8080`.

---

## Estructura del Proyecto

```
├── backend/        # Carpeta del backend con Laravel
│   ├── app/        # Código fuente de Laravel
│   ├── routes/     # Archivos de rutas (API)
│   └── ...
├── frontend/       # Carpeta del frontend con Vue + Vite
│   ├── src/        # Código fuente de Vue
│   ├── public/     # Archivos estáticos
│   └── ...
└── README.md
```

---

## API Endpoints

Los endpoints del backend expuestos en la API son:

- **GET /api/pastel**: Listar todos los elementos.
- **GET /api/pastel/{id}**: Obtener un elemento por ID.
- **POST /api/pastel**: Crear un nuevo elemento.
- **PUT /api/pastel/{id}**: Actualizar un elemento existente.
- **DELETE /api/pastel/{id}**: Eliminar un elemento.

---

## Vistas de Vue

En el directorio `frontend/src/views`, los principales vistas son:

1. **HomeView.vue**: Pagina principal.
2. **ReporteView.vue**: Vista de reportes.
3. **MainPastelView.vue**: Vista de los pasteles.
4. **MainIngredienteView.vue**: Vista de los ingredientes

---

## Scripts Disponibles

### Backend (Laravel):

- **`php artisan serve`**: Inicia el servidor de desarrollo.

### Frontend (Vue):

- **`npm run serve`**: Inicia el servidor de desarrollo.

---


## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

