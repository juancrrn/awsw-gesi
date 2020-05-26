<?php

/**
 * Puntos de entrada de vistas relacionadas con la sesión.
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

class Sesion extends Controlador
{
	public static function controla() : void
	{

		parent::go('/sesion/iniciar/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Sesion\Iniciar());
		});
		
		parent::go('/sesion/reset/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Sesion\RestablecerContrasena());
		});
		
		parent::go('/sesion/perfil/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Sesion\Perfil());
		});

	}
}