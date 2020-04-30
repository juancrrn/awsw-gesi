<?php 

/**
 * Vistas de mensajes de Secretaría.
 *
 * - PAS: pueden gestionar los mensajes.
 * - PD y estudiantes: pueden ver los mensajese enviados y enviar uno nuevo.
 * - Resto: pueden enviar mensajes.
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
use Awsw\Gesi\Datos\MensajeSecretaria;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Datos\Usuario;

class AdminLista extends Modelo
{
	private const VISTA_NOMBRE = "Mensajes de Secretaría";
	private const VISTA_ID = "mensaje-secretaria-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = MensajeSecretaria::dbGetAll();
	}

	public function procesaAntesDeLaCabecera() : void
	{
		Sesion::requerirSesionPs();
	}

	public function procesaContent() : void
	{

		// Comprobar si hay algún mensaje de secretaría.
		if (! empty($this->listado)) {

			$lista = <<< HTML
						<div id="mensajes-secretaria-lista">

HTML;

			foreach($this->listado as $m){
				if ($m->getUsuario()){
					$u = Usuario::dbGet($m->getUsuario());
					
					$from_nombre = $u->getNombre();
					$from_email = $u->getEmail();
					$from_telefono = $u->getNumeroTelefono();
				} else {
					$from_nombre = $m->getFromNombre();
					$from_email = $m->getFromEmail();
					$from_telefono = $m->getFromTelefono();
				}

				$fecha = strftime("%e de %B del %Y a las %H:%M", $m->getFecha());
				$contenido = $m->getContenido();

				$lista .= <<< HTML
							<div class="mensaje-secretaria">
								<header>
									<p class="from">
										<strong>$from_nombre</strong>
										$from_email
									</p>
									<p class="phone">$from_telefono</p>
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
						<p>En estos momentos no existe ningún mensaje de secretaría.</p>

HTML;

		}

		$html = <<< HTML
					<header class="page-header">
						<h1>Mensajes de Secretaría</h1>
					</header>
			
					<section class="page-content">
						<p>A continuación se muestra una lista con los mensajes de secretaría disponibles en la base de datos.</p>

						$lista
					</section>

HTML;

		echo $html;

	}
}

?>