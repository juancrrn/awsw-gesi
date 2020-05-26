<?php

/**
 * Puntos de entrada relacionados con la vista de landing.
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

class Home extends Controlador
{
	public static function controla() : void
	{

		parent::go('/?', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Home\Home());
		});

	}
}