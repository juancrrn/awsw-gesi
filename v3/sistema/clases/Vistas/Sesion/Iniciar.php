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

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Formularios\Sesion\Login as Formulario;

class Iniciar extends Modelo
{
	private const VISTA_NOMBRE = "Iniciar sesión";
	private const VISTA_ID = "sesion-iniciar";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesa() : void
	{

		$form = new Formulario("/sesion/iniciar/"); 
		$form->gestiona();

		$formulario = $form->getHtml();

		$html = <<< HTML
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Iniciar sesión</h1>
				</header>
		
				<section class="page-content">
					<p>Puede iniciar sesión rellenando el siguiente formulario.</p>

					$formulario
				</section>
			</div>
		</div>

HTML;

		echo $html;

	}
}

?>