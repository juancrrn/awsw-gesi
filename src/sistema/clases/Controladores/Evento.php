<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con eventos.
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

class Evento extends Controlador
{
	public static function controla() : void
	{

		parent::get('/eventos/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Evento\InvLista());
		});

		parent::get('/mi/eventos/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Evento\MiLista());
		});

		parent::get('/admin/eventos/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\Evento\AdminLista());
		});

	}
}