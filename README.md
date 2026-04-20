# Sistema Cooperativa

Este es el proyecto web para la gestión de la Cooperativa, desarrollado en PHP y MySQL.

## Requisitos Previos

- Tener instalado [XAMPP](https://www.apachefriends.org/es/index.html) (o un servidor equivalente con PHP y MySQL).
- Git instalado en tu computadora.

## Pasos para la instalación local (Colaboradores)

1. **Clonar el repositorio:**
   Abre la terminal en la carpeta `htdocs` de tu XAMPP (`C:\xampp\htdocs`) y ejecuta:
   ```bash
   git clone <URL_DEL_REPOSITORIO> Cooperativa
   cd Cooperativa
   ```

2. **Importar la Base de Datos:**
   - Abre XAMPP y asegúrate de que los servicios de **Apache** y **MySQL** estén iniciados.
   - Entra a [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
   - Crea una nueva base de datos llamada `cooperativa_db` (importante usar la codificación `utf8mb4_general_ci`).
   - Ve a la pestaña **Importar**, selecciona el archivo `cooperativa_db.sql` que se encuentra en la raíz de este proyecto y presiona **Importar**.

3. **Configurar las credenciales (Opcional):**
   - El archivo de conexión principal está en `assets/db.php`.
   - Por defecto, asume que tu usuario de MySQL es `root` y la contraseña es `1234` (o vacía `""` dependiendo de la configuración de tu equipo).
   - Si tienes credenciales diferentes, modifica temporalmente ese archivo de manera local a tus datos.

4. **Acceder a la aplicación:**
   - Abre tu navegador web.
   - Ve a [http://localhost/Cooperativa/](http://localhost/Cooperativa/) para ver el proyecto en funcionamiento.
