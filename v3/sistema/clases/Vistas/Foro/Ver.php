<?php 

/**
 * Vista de un foro en particular.
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

namespace Awsw\Gesi\Vistas\Foro;

use Awsw\Gesi\Datos\Foro;
use Awsw\Gesi\Vistas\Modelo;

class Ver extends Modelo
{

	private const VISTA_NOMBRE = "Foro";
	private const VISTA_ID = "foro-ver";

	private $foro;

	public function __construct(int $foro_id)
	{
		if (false) { // TODO: Comprobar que el id recibido existe
			$this->foro = Foro::dbGet($foro_id);
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
			<h1>Foro</h1>
		</header>

		<section class="page-content">
			<?php

var_dump($this->foro);

			?>
		</section>
	</div>
</div>
		<?php

	}
}

?>