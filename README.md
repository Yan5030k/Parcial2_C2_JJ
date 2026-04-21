Crendeciales para la db: Usuario:admin Contraseña: admin123

Parcial 2: Jhoan Ortega || Jeremias Neftaly 

**Proyecto:** Sistema de Catálogo y Administración para Xiaomi El Salvador.
---

### 7. Preguntas de justificación técnica

**¿Cómo manejan la conexión a la BD y qué pasa si algunos de los datos son incorrectos? Justifiquen la manera de validación de la conexión.**
Para la conexión a la base de datos implementamos la extensión `mysqli` orientada a objetos en un archivo independiente (`conexion.php`). En caso de que algún dato sea incorrecto (como el usuario, contraseña o nombre de la base de datos), el sistema captura el fallo mediante la propiedad `$conn->connect_error`. 
* **Justificación:** Validamos la conexión usando la función `die()` para detener la ejecución de inmediato si hay un error. Esto es fundamental por seguridad; si la conexión falla y no detenemos el script, PHP intentaría ejecutar el resto de las consultas SQL, lo que podría lanzar advertencias en pantalla que revelarían rutas o estructuras internas de nuestro servidor a posibles atacantes.

**¿Cuál es la diferencia entre `$_GET` y `$_POST` en PHP? ¿Cuándo es más apropiado usar cada uno? Da un ejemplo real de tu proyecto.**
* **`$_GET`:** Envía los datos a través de la URL de la página, haciéndolos visibles. Está limitado en la cantidad de información que puede enviar. Es apropiado usarlo para acciones de solo lectura, como parámetros de búsqueda o filtrado de catálogos que los usuarios puedan querer guardar en sus favoritos.
* **`$_POST`:** Envía los datos de forma oculta en el cuerpo de la solicitud HTTP (no se ven en la URL) y permite enviar grandes cantidades de datos. Es ideal para procesar información sensible o acciones que modifiquen la base de datos (INSERT, UPDATE, DELETE).
* **Ejemplo real en nuestro proyecto:** Utilizamos el método `$_POST` tanto en el archivo `login.php` (para que las credenciales del administrador viajen de forma segura y no queden expuestas en el historial del navegador) como en los formularios de `panel.php` (para registrar los datos de los nuevos smartphones y artículos del hogar).

**Tu app va a usarse en una empresa de la zona oriental. ¿Qué riesgos de seguridad identificas en una app web con BD que maneja datos de los usuarios? ¿Cómo los mitigarían?**
Al operar y almacenar el inventario de una sucursal en un polo comercial tan activo como San Miguel, el sistema queda expuesto a ataques que buscan robar información o alterar precios.
* **Riesgos identificados:** 1. *Inyección SQL (SQLi):* Un atacante podría ingresar código malicioso en los formularios de login o registro de productos para manipular o borrar la base de datos.
  2. *Secuestro de sesión:* Ingresar directamente a `panel.php` evadiendo la pantalla de login.
  3. *Exposición de credenciales:* Robo de contraseñas si se guardan en texto plano.
* **Cómo los mitigamos en esta implementación:** 1. Para evitar la inyección SQL, todas las entradas del administrador en `panel.php` y `login.php` pasan por `$conn->real_escape_string()` y la función `trim()` para limpiar caracteres especiales. 
  2. Protegimos la sesión verificando `if (!isset($_SESSION['usuario']))` al inicio de cada página privada; si alguien sin autorización intenta entrar por la URL, es redirigido inmediatamente al login. *(Nota de mejora futura: Las contraseñas en la BD se deben encriptar con `password_hash()`).*

---

### 8. Diccionario de Datos

**Nombre tabla:** `usuarios`
| Columna | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| id_usuario | INT | N/A | No | Llave primaria, autoincremental. Identificador único de cada usuario. |
| nombre_completo | VARCHAR | 100 | No | Nombre real y apellidos del miembro del staff. |
| username | VARCHAR | 50 | No | Nombre de usuario corto utilizado para acceder al sistema. |
| password | VARCHAR | 255 | No | Contraseña de acceso para validación en el login. |
| rol | VARCHAR | 20 | No | Define el nivel de permisos en el sistema (ej. admin). |

<br>

**Nombre tabla:** `smartphones`
| Columna | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| id_celular | INT | N/A | No | Llave primaria, autoincremental para cada teléfono. |
| modelo | VARCHAR | 100 | No | Nombre comercial del equipo (ej. Poco X6 Pro). |
| serie | VARCHAR | 50 | No | Familia o categoría a la que pertenece el equipo. |
| precio | DECIMAL | 10,2 | No | Precio de venta al público (permite hasta 2 decimales). |
| especificaciones_adicionales | TEXT | 65,535 (Max) | Sí | Detalles extra del procesador, cámara o promociones incluidas en la caja. |

<br>

**Nombre tabla:** `hogar_inteligente`
| Columna | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| id_dispositivo | INT | N/A | No | Llave primaria, autoincremental para cada aparato. |
| nombre_equipo | VARCHAR | 100 | No | Nombre del dispositivo inteligente de la tienda. |
| categoria_hogar | VARCHAR | 50 | No | Clasificación funcional (Limpieza, Salud, Cocina, Seguridad). |
| garantia_meses | INT | N/A | No | Tiempo de garantía que cubre al producto expresado en meses. |
| observaciones | TEXT | 65,535 (Max) | Sí | Notas sobre restricciones de uso, regiones o empaque. |
