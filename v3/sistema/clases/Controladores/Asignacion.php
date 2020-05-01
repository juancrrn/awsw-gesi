<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con asignacion.
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

class Asignacion extends Controlador
{
	public static function controla() : void
	{

		parent::go('/admin/asignaciones/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminLista());
		});
		
		parent::go('/admin/asignaciones/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminCrear());
		});
		
		parent::go('/admin/asignaciones/([0-9]+)/ver/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminVer($asignacion_id));
		});
		
		parent::go('/admin/asignaciones/([0-9]+)/editar/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminEditar($asignacion_id));
		});
		
		parent::go('/admin/asignaciones/([0-9]+)/eliminar/', function ($asignacion_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminEliminar($asignacion_id));
		});

		parent::go('/mi/asignaciones/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\AdminLista());
		});

		parent::go('/mi/asignaciones/horario/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Asignacion\MiHorario());
		});

	}
}