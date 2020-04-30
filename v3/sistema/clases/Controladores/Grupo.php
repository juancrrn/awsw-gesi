<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con grupos.
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

class Grupo extends Controlador
{
	public static function controla() : void
	{

		parent::go('/admin/grupos/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\AdminLista());
		});
		
		parent::go('/admin/grupos/crear/', function ($grupo_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\AdminCrear($grupo_id));
		});
		
		parent::go('/admin/grupos/([0-9]+)/ver/', function ($grupo_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\AdminVer($grupo_id));
		});
		
		parent::go('/admin/grupos/([0-9]+)/editar/', function ($grupo_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\AdminEditar($grupo_id));
		});
		
		parent::go('/admin/grupos/([0-9]+)/eliminar/', function ($grupo_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\AdminEliminar($grupo_id));
		});

		parent::go('/mi/grupos/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Grupo\MiLista());
		});

	}
}