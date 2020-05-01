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
use Awsw\Gesi\Formularios\Grupo\AdminCrear as Formulario;

class AdminCrear extends Modelo
{
	private const VISTA_NOMBRE = "Crear grupo";
	private const VISTA_ID = "grupo-admin-crear";

	private $formulario;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->formulario = new Formulario('/admin/grupos/crear/');

		
	}

	public function procesaContent() : void 
	{

		$form = $this->formulario->getHtml();

		$html = <<< HTML
<header class="page-header">
	<h1>$this->nombre</h1>
</header>

<section class="page-content">
	$form
</section>
	
HTML;

		echo $html;

	}
}

?>