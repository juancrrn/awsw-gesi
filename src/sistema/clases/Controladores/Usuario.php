<?php

/**
 * Puntos de entrada de vistas relacionadas con usuarios.
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

use Awsw\Gesi\FormulariosAjax\Usuario\EstudianteAdminCreate as EstudianteAdminCreate;
use Awsw\Gesi\Vistas\Vista as V;

class Usuario extends Controlador
{
	public static function controla() : void
	{

		parent::go('/admin/usuarios/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Usuario\AdminLista());
		});
		
		parent::go('/admin/usuarios/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Usuario\AdminCrear());
		});
		
		parent::go('/admin/usuarios/([0-9]+)/ver/', function ($usuario_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Usuario\AdminVer($usuario_id));
		});
		
		parent::go('/admin/usuarios/([0-9]+)/editar/', function ($usuario_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Usuario\AdminEditar($usuario_id));
		});

		parent::go('/admin/usuarios/([0-9]+)/eliminar/', function ($usuario_id) {
			V::dibuja(new \Awsw\Gesi\Vistas\Usuario\AdminEliminar($usuario_id));
		});

		// Formularios AJAX.

		parent::go('/admin/estudiantes/create/', function () {
			$formulario = new EstudianteAdminCreate();

			$formulario->manage();
		});

	}
}