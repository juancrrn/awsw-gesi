<?php

/**
 * Vista de inicio de sesión.
 *
 * Invitado (cualquiera): puede iniciar sesión.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundar
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Formularios\Sesion\Iniciar as Formulario;

class Iniciar extends Modelo
{
	private const VISTA_NOMBRE = "Iniciar sesión";
	private const VISTA_ID = "sesion-iniciar";

	private $form;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->form = new Formulario("/sesion/iniciar/"); 

		$this->form->gestiona();
	}

	public function procesaContent() : void
	{

		$formulario = $this->form->getHtml();
		

		$html = <<< HTML
					<section class="page-content">
						$formulario
					</section>

HTML;

		echo $html;

	}
}

?>