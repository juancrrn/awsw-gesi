<?php 

/**
 * TODO: NOMBRE DE LA CLASE
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

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class AdminEditar extends Modelo
{
	private const VISTA_NOMBRE = "Editar grupo ";// TODO completar nombre
	private const VISTA_ID = "grupo-admin-editar";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesaAntesDeLaCabecera(): void
	{
		Sesion::requerirSesionPs();
	}

	public function procesaContent() : void 
	{

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>

		<section class="page-content">
			<p>Contenido</p>
		</section>

HTML;

		echo $html;

	}
}

?>