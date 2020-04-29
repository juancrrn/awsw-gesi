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

use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use \Awsw\Gesi\Datos\MensajeSecretaria;
use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Vistas\Vista;

class Lista extends Modelo
{
	private const VISTA_NOMBRE = "Mensajes de Secretaría";
	private const VISTA_ID = "mensaje-secretaria-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = MensajeSecretaria::dbGetAll(); // TODO: recuperar el listado de mensajes de secretaría
	}

	public function procesaAntesDeLaCabecera() : void
	{
		Sesion::requerirSesionPs();
	}

	public function procesa() : void
	{

		?>
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Mensajes de Secretaría</h1>
				</header>
		
				<section class="page-content">
					<p>A continuación se muestra una lista con los mensajes de secretaría disponibles en la base de datos.</p>
					<?php

		// Comprobar si hay algún mensaje de secretaría.
		if (MensajeSecretaria::dbAny()) {

					?><div id="mensajes-secretaria-lista"><?php

			$mensajes = MensajeSecretaria::dbGetAll();

			foreach($mensajes as $mensaje){
				if ($mensaje->getUsuario()){
					$usuario = Usuario::dbGet($mensaje->getUsuario());
					
					$from_nombre = $usuario->getNombre();
					$from_email = $usuario->getEmail();
					$from_telefono = $usuario->getNumeroTelefono();
				} else {
					$from_nombre = $mensaje->getFromNombre();
					$from_email = $mensaje->getFromEmail();
					$from_telefono = $mensaje->getFromTelefono();
				}

						?><article class="mensaje-secretaria">
							<header>
								<p class="from"><?php echo '<strong>' . $from_nombre . '</strong> ' . $from_email; ?></p>
								<p class="phone"><?php echo $from_telefono; ?></p>
								<p class="date"><?php echo strftime("%e de %B del %Y a las %H:%M", $mensaje->getFecha()); ?></p>
							</header>

							<section class="content">
								<?php echo $mensaje->getContenido(); ?>
							</section>
						</article><?php

			}

					?></div><?php

		// Si no hay ningún mensaje, avisar.
		} else {

					?><p>En estos momentos no existe ningún mensaje de secretaría.</p><?php

		}
            		?>
				</section>
			</div>
		</div>
		<?php

	}
}

?>