<?php 

/**
 * Vista de landing.
 *
 * Invitados: verán información de acceso público.
 * Usuarios registrados: verán información personalizada.
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

namespace Awsw\Gesi\Vistas\Home;

use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;

class Home extends Modelo
{
	private const VISTA_NOMBRE = "Inicio";
	private const VISTA_ID = "inicio";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesa() : void
	{

		$app = App::getSingleton();

		$html = <<< HTML
				<article id="master-grid-content">
					<header class="page-header">
						<h1>Inicio</h1>
					</header>
					<section class="page-content">

HTML;
		
		if (Sesion::isSesionIniciada()) {

			$nombre = Sesion::getUsuarioEnSesion()->getNombre();

			$html .= <<< HTML
						<p>¡Te damos la bienvenida, $nombre!</p>

HTML;
		
			if (Sesion::getUsuarioEnSesion()->isPs()) {

				$html .= <<< HTML
						<p>Por el momento, puedes <a href="mensajes.php">ver los mensajes dirigidos a la secretaría del centro</a>.</p>

HTML;
		
			} else {

				$html .= <<< HTML
						<p>Por el momento, puedes <a href="mensajes.php">enviar un mensaje a la secretaría del centro</a>.</p>

HTML;
		
			}
		
		} else {

			$url = $app->getUrl();

			$html .= <<< HTML
						<div id="landing-welcome">
			
							<img src="$url/img/landing.svg" alt="">
			
							<h1>¡Hola!</h1>
			
							<p>Te damos la bienvenida. Gesi es la aplicación web que gestiona tu instituto de educación secundaria. Accede a los contenidos iniciando sesión.</p>
			
							<p id="landing-login"><a class="btn" href="$url/sesion/iniciar/">Iniciar sesión</a></p>
						
						</div>

HTML;
		
		}

		$html .= <<< HTML
					</section>
				</article>

				<aside id="master-grid-side">
					<ul>
						<li><a href="">Otros enlaces</a></li>
					</ul>
				</aside>

HTML;

		echo $html;

	}
}

?>