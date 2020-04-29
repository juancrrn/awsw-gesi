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

use Awsw\Gesi\Datos\MensajeSecretaria;
use Awsw\Gesi\Vistas\Modelo;

class Ver extends Modelo
{

	private const VISTA_NOMBRE = "Mensaje de Secretaría";
	private const VISTA_ID = "mensaje-secretaria-ver";

	private $mensaje_secretaria;

	public function __construct(int $mensaje_secretaria_id)
	{
		if (false) { // TODO: Comprobar que el id recibido existe
			$this->mensaje_secretaria = MensajeSecretaria::dbGet($mensaje_secretaria_id);
		} else {
			// TODO: Redireccionar y mostrar errores
		}

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesa() : void
	{

		?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Mensaje de Secretaría</h1>
		</header>

		<section class="page-content">
			<?php

var_dump($this->mensaje_secretaria);

			?>
		</section>
	</div>
</div>
		<?php

	}
}

?>