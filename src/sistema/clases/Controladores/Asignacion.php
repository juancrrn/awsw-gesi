<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con asignacion.
 * 
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsCreate;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsRead;
use Awsw\Gesi\FormulariosAjax\Asignacion\AsignacionPsUpdate;
use Awsw\Gesi\Vistas\Asignacion\AsignacionPsList;
use Awsw\Gesi\Vistas\Asignacion\AsignacionPdList;
use Awsw\Gesi\Vistas\Vista;

class Asignacion extends Controlador
{

	public static function controla() : void
	{

		/**
		 * Personal de Secretaría.
		 */

		parent::get('/ps/asignaciones/', function () {
			Vista::dibuja(new AsignacionPsList());
		});

		// Create.
		parent::get('/ps/asignacion/create/', function () {
			(new AsignacionPsCreate)->manage();
		});
		parent::post('/ps/asignacion/create/', function () {
			(new AsignacionPsCreate)->manage();
		});

		// Read.
		parent::get('/ps/asignacion/read/', function () {
			(new AsignacionPsRead)->manage();
		});

		// Update.
		parent::get('/ps/asignacion/update/', function () {
			(new AsignacionPsUpdate)->manage();
		});
		parent::patch('/ps/asignacion/update/', function () {
			(new AsignacionPsUpdate)->manage();
		});

		/**
		 * Personal Docente
		 */
		parent::get('/pd/asignaciones/', function() {
			Vista::dibuja(new AsignacionPdList());
		});


		/*
		parent::get('/admin/asignaciones/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminCrear());
		});
		
		parent::get('/admin/asignaciones/([0-9]+)/ver/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminVer($asignacion_id));
		});
		
		parent::get('/admin/asignaciones/([0-9]+)/editar/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminEditar($asignacion_id));
		});
		
		parent::get('/admin/asignaciones/([0-9]+)/eliminar/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminEliminar($asignacion_id));
		});

		parent::get('/admin/asignaciones/', function () {
			Vista::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminLista());
		});

		parent::get('/mi/asignaciones/', function () {
			Vista::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminLista());
		});

		parent::get('/mi/asignaciones/horario/', function () {
			Vista::dibuja(new \Awsw\Gesi\Vistas\Asignacion\MiHorario());
		});
		*/

	}
}