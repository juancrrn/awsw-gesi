<?php

/**
 * Puntos de entrada relacionados con las vistas relacionadas con asignaturas.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Vista as V;

class Asignatura extends Controlador
{
	public static function controla() : void
	{

		parent::go('/admin/asignaturas/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\AdminLista());
		});

		parent::go('/admin/asignaturas/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\AdminCrear());
		});
		
		parent::go('/admin/asignaturas/([0-9]+)/ver/', function ($asignatura_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\AdminVer($asignatura_id));
		});
		
		parent::go('/admin/asignaturas/([0-9]+)/editar/', function ($asignatura_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\AdminEditar($asignatura_id));
		});
		
		parent::go('/admin/asignaturas/([0-9]+)/eliminar/', function ($asignatura_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\AdminEliminar($asignatura_id));
		});

		parent::go('/mi/asignaturas/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\MiLista());
		});
		
		parent::go('/mi/asignaturas/([0-9]+)/ver/', function ($asignatura_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignatura\MiVer($asignatura_id));
		});

	}
}