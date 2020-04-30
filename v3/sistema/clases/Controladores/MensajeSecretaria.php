<?php

/**
 * Puntos de entrada de vistas relacionadas con mensajes de Secretaría.
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

class MensajeSecretaria extends Controlador
{
	public static function controla() : void
	{

		/**
		 * Admin
		 */

		parent::go('/admin/secretaria/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\AdminLista());
		});

		/**
		 * Sesión iniciada
		 */
		
		parent::go('/mi/secretaria/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\MiLista());
		});

		parent::go('/mi/secretaria/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\MiCrear());
		});

		/**
		 * Públicos
		 */

		parent::go('/secretaria/crear/', function () {
			V::dibuja(new \Awsw\Gesi\Vistas\MensajeSecretaria\PublicoCrear());
		});

	}
}

?>