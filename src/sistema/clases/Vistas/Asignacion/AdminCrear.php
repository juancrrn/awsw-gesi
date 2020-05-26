<?php

/**
 * Métodos relacionados con las asignaturas.
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



 
namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Formularios\Asignacion\AdminCrear as Formulario;


class AdminCrear extends Modelo
{
	private $form;
	private const VISTA_NOMBRE = "Nueva asignacion";
	private const VISTA_ID = "asignacion-crear";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->form = new Formulario("/admin/asignaciones/crear/"); 
		Sesion::requerirSesionPs();

		$this->form->gestiona();
	}


	public function procesaContent() : void
	{

		$formulario = $this->form->getHtml();

		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>

		<section class="page-content">
			$formulario
		</section>

HTML;

		echo $html;

	}
}

?>t