<?php

/**
 * Front controller.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

require_once __DIR__ . "/sistema/configuracion.php";

use Awsw\Gesi\App;
use \Awsw\Gesi\Controlador;
use \Awsw\Gesi\Vistas\Vista as V;

Controlador::setGetBase(App::getSingleton()->getBaseControlador());

/**
 * Vista de landing.
 */

Controlador::go('/?', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Home\Home());
});

/**
 * Vistas relacionadas con las asignaturas
 */

Controlador::go('/asignaturas/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\Lista());
});

Controlador::go('/asignaturas/([0-9]+)/ver/', function ($asignatura_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\Ver($asignatura_id));
});

/**
 * Vistas relacionadas con la biblioteca
 */

Controlador::go('/biblioteca/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Biblioteca\General());
});

Controlador::go('/biblioteca/movimientos/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Biblioteca\Movimientos());
});

/**
 * Vistas relacionadas con eventos y calendario
 */

Controlador::go('/eventos/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Evento\Lista());
});

Controlador::go('/eventos/([0-9]+)/ver/', function ($evento_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\Evento\Ver($evento_id));
});

/**
 * Vistas relacionadas con foros
 */

Controlador::go('/foros/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Foro\Lista());
});

Controlador::go('/foros/([0-9]+)/ver/', function ($foro_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\Foro\Ver($foro_id));
});

/**
 * Vistas relacionadas con grupos
 */

Controlador::go('/grupos/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Grupo\Lista());
});

Controlador::go('/grupos/([0-9]+)/ver/', function ($grupo_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\Grupo\Ver($grupo_id));
});

/**
 * Vistas relacionadas con mensajes de secretaría
 */

Controlador::go('/secretaria/mensajes/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\Lista());
});

Controlador::go('/secretaria/mensajes/crear/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\Crear());
});

Controlador::go('/secretaria/mensajes/([0-9]+)/ver/', function ($mensaje_secretaria_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\Ver($mensaje_secretaria_id));
});

/**
 * Vistas relacionadas con sesión
 */

Controlador::go('/sesion/iniciar/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Sesion\Iniciar());
});

Controlador::go('/sesion/cerrar/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Sesion\Cerrar());
});

Controlador::go('/sesion/reset/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Sesion\RestablecerContrasena());
});

/**
 * Vistas relacionadas con usuarios
 */

Controlador::go('/usuarios/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Usuario\Lista());
});

Controlador::go('/usuarios/crear/', function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Usuario\Crear());
});

Controlador::go('/usuarios/([0-9]+)/ver/', function ($usuario_id) {
	V::dibuja(new \Awsw\Gesi\Vistas\Usuario\Ver($usuario_id));
});

/**
 * Vista por defecto.
 */

Controlador::default(function () {
	V::dibuja(new \Awsw\Gesi\Vistas\Error\Error404());
});

?>