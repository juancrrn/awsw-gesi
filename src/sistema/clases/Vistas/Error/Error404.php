<?php 

/**
 * Error 404: no encontrado.
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

namespace Awsw\Gesi\Vistas\Error;

use Awsw\Gesi\Vistas\Modelo;

class Error404 extends Modelo
{

	private const VISTA_NOMBRE = "Error 404";
	private const VISTA_ID = "error-404";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesaContent() : void
	{

		$html = <<< HTML
					<header class="page-header">
						<h1>Error 404</h1>
					</header>
					
					<section class="page-content">
						<p>No se ha podido encontrar la página solicitada.</p>
					</section>

HTML;

		echo $html;

	}
}

?>