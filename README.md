# PRIMER PARCIAL – PROGRAMACIÓN III                                                 2 cuat. 2023

Aclaración:
Las partes se corregirán de manera secuencial (ascendentemente). Si están bien todos los puntos de una parte, habilita la
corrección de la parte posterior.
Se debe crear un archivo por cada entidad de PHP.
Todas las entidades deben estar dentro de un namespace (**Apellido\Nombre** del alumno).
Todos los métodos deben estar declarados dentro de clases. Se tendrá encuentra la aplicación de PSR-1, el tipado de atributos,
parámetros y valores de retorno.
PDO es requerido para interactuar con la base de datos.
Se deben respetar los nombres de los archivos, de las clases, de los métodos y de los parámetros.
Todas las referencias a archivos y/o recursos, deben estar de manera relativa.

## Parte 1 (hasta un 5)
**auto.php**. Crear, en **./clases**, la clase **Auto** con atributos protegidos:
- patente(cadena)
- marca(cadena)
- color(cadena)
- precio(flotante)
Un constructor (que inicialice los atributos), un método de instancia **toJSON()**, que retornará los datos de la
instancia (en una cadena con formato **JSON**).

Método de instancia **guardarJSON($path)**, que agregará al auto en el path recibido por parámetro. Retornará un
**JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

Método de clase **traerJSON($path)**, que retornará un array de objetos de tipo auto (recuperados del path).

Método de clase **verificarAutoJSON($auto)**, que recorrerá el array obtenido del método traerJSON y retornará un
**JSON** que contendrá: existe(bool) y mensaje(string).

**Nota**: Si el auto está registrado (comparar por patente), retornará **true**. Caso contrario, retornará **false**, y en el
mensaje se informará de lo acontecido.


En el directorio raíz del proyecto, agregar las siguientes páginas:

**altaAutoJSON.php**: Se recibe por POST la **patente**, la **marca**, el **color** y el **precio**. Invocar al método **guardarJSON** y
pasarle **'./archivos/autos.json'** cómo parámetro.

**verificarAutoJSON.php**: Se recibe por POST la patente.
Retornar un **JSON** que contendrá: éxito(bool) y mensaje(string) (agregar el mensaje obtenido del método
verificarAutoJSON).

**listadoAutosJSON.php**: (GET) Se mostrará el listado de todos los autos en formato **JSON** (traerJSON). Pasarle
'./archivos/autos.json' cómo parámetro.

**autoBD.php**. Crear, en **./clases**, la clase **AutoBD** (hereda de Auto) con atributo protegido:
- pathFoto(cadena)

Un constructor (con parámetros opcionales), un método de instancia **toJSON()**, que retornará los datos de la
instancia (en una cadena con formato JSON).
Crear, en **./clases**, la interface **IParte1**. Esta interface poseerá los métodos:
- **agregar**: agrega, a partir de la instancia actual, un nuevo registro en la tabla **autos** (patente, marca, color,
precio, foto), de la base de datos **garage_bd**. Retorna **true**, si se pudo agregar, **false**, caso contrario.
- **traer**: este método estático retorna un array de objetos de tipo AutoBD, recuperados de la base de datos.

Implementar la interfaz en la clase AutoBD.

**agregarAutoSinFoto.php**: Se recibe por POST el parámetro **auto_json** (patente, marca, color y precio), en formato
de cadena JSON. Se invocará al método **agregar**.
Se retornará un **JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

**listadoAutosBD.php**: (GET) Se mostrará el listado **completo** de los autos (obtenidos de la base de datos) en una
tabla (HTML con cabecera). Invocar al método **traer**.

**Nota**: Si se recibe el parámetro **tabla** con el valor **mostrar**, retornará los datos en una tabla (HTML con cabecera),
preparar la tabla para que muestre la imagen, si es que la tiene.
Si el parámetro no es pasado o no contiene el valor ‘mostrar’, retornará el array de objetos con formato JSON.

## Parte 2 (hasta un 6)

Crear, en **./clases**, la interface **IParte2**. Esta interface poseerá los métodos:

- **eliminar**: este método **estático**, elimina de la base de datos el registro coincidente con la **patente** recibida
cómo parámetro. Retorna **true**, si se pudo eliminar, **false**, caso contrario.
- **modificar**: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por
patente). Retorna **true**, si se pudo modificar, **false**, caso contrario.

Implementar la interfaz en la clase AutoBD.

**eliminarAutoBD.php**: Recibe el parámetro **auto_json** (patente, marca, color y precio, en formato de cadena JSON)
por POST y se deberá borrar el auto (invocando al método **eliminar**).
Si se pudo borrar en la base de datos, invocar al método guardarJSON y pasarle cómo parámetro el valor **'./archivos/autos_eliminados.json'**.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

**modificarAutoBD.php**: Se recibirán por POST los siguientes valores: **auto_json** (patente, marca, color y precio, en
formato de cadena JSON) para modificar un auto en la base de datos. Invocar al método **modificar**.

Se retornará un **JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

## Parte 3 (hasta un 8)

Crear, en **./clases**, la interface **IParte3**. Esta interface poseerá el método:
- **existe**: retorna true, si la instancia actual está en el array de objetos de tipo AutoBD que recibe como
parámetro (comparar por patente). Caso contrario retorna false.
- **guardarEnArchivo**: escribirá en un archivo de texto (**./archivos/autosbd_borrados.txt**) toda la información del auto más la nueva ubicación de la foto. La foto se moverá al subdirectorio “./autosBorrados/”, con el nombre formado por la patente punto **'borrado'** punto hora, minutos y segundos del borrado (**Ejemplo: AYF714.renault.borrado.105905.jpg**).

Se retornará un **JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

**verificarAutoBD.php**: Se recibe por POST el parámetro **obj_auto**, que será una cadena **JSON** (patente), si coincide
con algún registro de la base de datos (invocar al método **traer**) retornará los datos del objeto (invocar al **toJSON**).
Caso contrario, un JSON vacío ({}).

**agregarAutoBD.php**: Se recibirán por POST los valores: **patente**, **marca**, **color**, **precio** y la **foto** para registrar un
auto en la base de datos.
Verificar la previa existencia del auto invocando al método existe. Se le pasará como parámetro el array que
retorna el método **traer**.
Si el auto ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
Si el auto no existe, se invocará al método **agregar**. La imagen se guardará en “./autos/imagenes/”, con el nombre
formado por la **patente** punto hora, minutos y segundos del alta (**Ejemplo: AYF714.105905.jpg**).
Se retornará un **JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

**eliminarAutoBDFoto.php**: Se recibe el parámetro **auto_json** (patente, marca, color, precio y pathFoto en formato
de cadena JSON) por POST. Se deberá borrar el auto (invocando al método **eliminar**).
Si se pudo borrar en la base de datos, invocar al método **guardarEnArchivo**.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los autos
borrados y sus respectivas imágenes.

**modificarAutoBDFoto.php**: Se recibirán por POST los siguientes valores: **auto_json** (patente, marca, color y
precio, en formato de cadena JSON) y la **foto** (para modificar un auto en la base de datos). Invocar al método
**modificar**.
Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
“./autosModificados/”, con el nombre formado por la **patente** punto **'modificado'** punto hora, minutos y segundos
de la modificación (**Ejemplo: AYF714.renault.modificado.105905.jpg**).
Se retornará un **JSON** que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los autos
modificados y sus respectivas imágenes.

## Parte 4 (hasta un 10)

En el directorio raíz del proyecto, agregar la siguiente página:

**listadoAutosPDF.php**: (GET) Generar un listado de los autos de la base de datos y mostrarlo con las siguientes
características:
- Encabezado (apellido y nombre del alumno a la izquierda y número de página a la derecha).
- Cuerpo (Título del listado, listado completo de los autos con su respectiva foto).
- Pie de página (fecha actual, centrada).
