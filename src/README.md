# Gesi

Aplicación de gestión de institutos de educación secundaria
awsw-gesi
Versión 0.0.4-beta.01

**Autores**

- Andrés Ramiro Ramiro
- Nicolás Pardina Popp
- Pablo Román Morer Olmos
- Juan Francisco Carrión Molina

## Nota

Esta entrega se presenta como una versión preliminar, ya que hemos decidido
continuar implementando y añadiendo más funcionalidad. Por lo tanto, este
fichero es simplemente una descripción para una correción inicial, y no una
memoria final del proyecto.

El cambio principal con respecto a la versión 0.0.3 es que se han transformado
todos los formularios a una gesión a través de AJAX (PHP, JavaScript y jQuery)
con la intención de aligerar la carga de las páginas y mejorar la usabilidad y
la experiencia de usuario.

Para ello, hemos pasado, en primer lugar, a utilizar Bootstrap como framework
par la interfaz de usuario. Bootstrap facilita la creación y precarga de los
formularios. También conservamos parte del CSS propio para algunas partes de la
aplicación.

En segundo lugar, creamos un sistema de gesión centralizada de los formularios
mediante la clase `FormularioAjax`, que se encarga de atender las peticiones,
mapear los campos, realizar la verificación CSRF, etc. Y, en el lado del
cliente, en `app.js` se implementa la funcionalidad para precargar los
formularios, enviarlos y gestionar lo que pasa cuando se recibe una respuesta
satisfactoria (eventos _on-success_ gestionados por las funciones de
`funcionesOnSuccess.js`).

Las clases del subespacio de nombres `FormulariosAjax` extienden
`FormularioAjax` y representan cada formulario de gesión de cada clase.
Utilizamos la nomenclatura CRUD (_create, read, update y delete_) para nombrar
los formularios, y la semántica HTTP  (_POST, GET, PATCH y DELETE_) para
enviarlos y gestionar las URL de los controladores.

Así, el identificador de un formulario tendrá formato:

`{clase}-{actor}-{acción}`

- `{clase}` Es el nombre de la clase que se va a modificar, por ejemplo
  `usuario` o `foro`.
- `{actor}` Es el tipo de usuario que realiza la acción y puede ser `est`, `pd`,
  `ps`, `ses` o `inv`.
- `{acción}` Es la acción CRUD a realizar.

Por ejemplo, `foro-ps-create` (formulario de creación de un foro por parte de un
usuario con rol de personal de Secretaría).

También se ha retocado la estructura de la base de datos, se han añadido
distintas restricciones y se han generado datos de demostración (carpeta
`mysql`).

**La contraseña de todos los usuarios de demostración es `holamundo`.**

## Funcionalidad por implementar

- Todos los comentarios marcados con `TODO`.
- Finalización de vistas, URL de controladores y enlaces del menú lateral.
- Comprobar, al insertar usuarios, que NIF y email no existen ya, ya que son
  UNIQUE.
- Habilitar verificación formato NIF.
- Verificación antes de enviar los formularios, en el cliente; campos required y
  asterisco.
- Representación gráfica de horarios.
- Al eliminar una asignación, si procede, eliminar también el foro y los
  mensajes (CASCADE).
- Que un foro solo pueda ser foro principal de una asignatura (en curso).
- Restricciones nombres cortos asignatura y grupo.
- Vista de recuperar contraseña.
- Que un profesor pueda crear eventos para asignaturas enteras.
- ...
- Permisos de vistas (est, pd, ps) Falta
      - MensajeForoPdList
      - MensajeForoPsList
      - (Biblioteca)
- Foro Eventos
- Revisar descripciones de métodos y clases