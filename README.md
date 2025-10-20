# ururutech_draftosaurus_tracker
Presentamos a Draftosaurus Tracker, un sistema que sirve como una herramienta auxiliar para facilitar la puntuación y la aplicación de reglas, mejorando la experiencia de los jugadores.

## Configuración de la aplicación MVC

La nueva aplicación ubicada en `draftosaurus-mvc/` puede desplegarse directamente en `htdocs/draftosaurus-mvc` dentro de XAMPP u otro servidor Apache compatible. El directorio `public/` contiene todos los archivos estáticos (CSS, JS y assets) además de las vistas PHP que renderizan la interfaz.

### Variables de entorno de la base de datos

El archivo `draftosaurus-mvc/config/database.php` utiliza como valores predeterminados el esquema compartido `DRAFTOSAURUS` sobre `localhost` y el usuario `root` sin contraseña. Puedes sobreescribir estos valores mediante las siguientes variables de entorno antes de iniciar el servidor:

| Variable        | Descripción                   | Valor por defecto |
|-----------------|-------------------------------|-------------------|
| `DB_HOST`       | Host de la base de datos      | `localhost`       |
| `DB_PORT`       | Puerto del servicio MariaDB   | `3306`            |
| `DB_DATABASE`   | Nombre de la base de datos    | `DRAFTOSAURUS`    |
| `DB_USERNAME`   | Usuario con permisos de acceso| `root`            |
| `DB_PASSWORD`   | Contraseña del usuario        | *(vacío)*         |
| `DB_CHARSET`    | Conjunto de caracteres        | `utf8mb4`         |

Estas variables mantienen la compatibilidad con el esquema compartido utilizado por los controladores y pruebas de regresión.
