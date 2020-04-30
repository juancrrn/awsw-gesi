<?php 

/**
 * Vista de perfil de un usuario en particular.
 *
 * - Cualquier usuario con sesión puede acceder.
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

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;

class Perfil extends Modelo
{

	private const VISTA_NOMBRE = "Mi perfil";
	private const VISTA_ID = "sesion-perfil";

	public function __construct()
	{
		Sesion::requerirSesionIniciada();

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesaContent() : void
	{

		// TODO: Rellenar formulario con Sesion::getUsuarioLogueado

		$html = <<< HTML
					<header class="page-header">
						<h1>Mi perfil</h1>
					</header>

					<section class="page-content">
						Aquí el formulario read-only.
					</section>

HTML;

		echo $html;

	}
}

?>