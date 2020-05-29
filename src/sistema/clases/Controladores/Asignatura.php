<?php

/**
 * Puntos de entrada relacionados con las vistas relacionadas con asignaturas.
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

use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsCreate;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsRead;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsUpdate;
use Awsw\Gesi\FormulariosAjax\Asignatura\AsignaturaPsDelete;
use Awsw\Gesi\Vistas\Asignatura\AsignaturaPsList;

use Awsw\Gesi\Vistas\Vista;

class Asignatura extends Controlador
{

	public static function controla() : void
	{
		/**
		 * Vista lista de asignaturas.
		 */

		parent::get('/ps/asignaturas/', function () {
			Vista::dibuja(new AsignaturaPsList());
		});

		// Create.
		parent::get('/ps/asignaturas/create/', function () {
			(new AsignaturaPsCreate(true))->manage();
		});
		parent::post('/ps/asignaturas/create/', function () {
			(new AsignaturaPsCreate(true))->manage();
		});

		// Read.
		parent::get('/ps/asignaturas/read/', function () {
			(new AsignaturaPsRead(true))->manage();
		});
		parent::post('/ps/asignaturas/read/', function () {
			(new AsignaturaPsRead(true))->manage();
		});

		// Update.
		parent::get('/ps/asignaturas/update/', function () {
			(new AsignaturaPsUpdate(true))->manage();
		});
		parent::patch('/ps/asignaturas/update/', function () {
			(new AsignaturaPsUpdate(true))->manage();
		});

		// Delete.
		parent::get('/ps/asignaturas/delete/', function () {
			(new AsignaturaPsDelete(true))->manage();
		});
		parent::delete('/ps/asignaturas/delete/', function () {
			(new AsignaturaPsDelete(true))->manage();
		});
	}
}

?>