<?php 

/**
 * Vista de lista de mensajes de Secretaría enviados por el usuario en sesión.
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

namespace Awsw\Gesi\Vistas\MensajeSecretaria;

use Awsw\Gesi\Vistas\Modelo;
use \Awsw\Gesi\Datos\MensajeSecretaria;
use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\Datos\Usuario;

class MiLista extends Modelo
{
	private const VISTA_NOMBRE = "Mensajes de Secretaría";
	private const VISTA_ID = "mensaje-secretaria-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$usuario_id = Sesion::getUsuarioEnSesion()->getId();
		$this->listado = MensajeSecretaria::dbGetByUsuario($usuario_id);
	}

	public function procesaAntesDeLaCabecera() : void
	{
		Sesion::requerirSesionIniciada();
	}

	public function procesaContent() : void
	{

		// Comprobar si hay algún mensaje de secretaría.
		if (! empty($this->listado)) {

			$lista = <<< HTML
						<div id="mensajes-secretaria-lista">

HTML;

			foreach($this->listado as $m){
				$fecha = strftime("%e de %B del %Y a las %H:%M", $m->getFecha());
				$contenido = $m->getContenido();

				$lista .= <<< HTML
							<div class="mensaje-secretaria">
								<header>
									<p class="from">
										<strong>(Yo)</strong>
									</p>
									<p class="date">$fecha</p>
								</header>

								<section class="content">
									$contenido
								</section>
							</div>

HTML;

			}

			$lista .= <<< HTML
						</div>

HTML;

		// Si no hay ningún mensaje, avisar.
		} else {

			$lista = <<< HTML
						<p>Aún no has enviado ningún mensaje de Secretaría.</p>

HTML;

		}

		$html = <<< HTML
					<header class="page-header">
						<h1>Mensajes de Secretaría</h1>
					</header>
			
					<section class="page-content">
						<p>A continuación se muestra una lista con los mensajes de Secretaría que has enviado.</p>

						$lista
					</section>

HTML;

		echo $html;

	}
}

?>