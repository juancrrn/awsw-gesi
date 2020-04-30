<?php 

/**
 * Vista de una asignatura en particular.
 *
 * - PAS: puede editar la asignatura (información, datos, etc.).
 * - PD: puede publicar en el foro y así añadir recursos, etc.
 * - Estudiante: puede ver los foros etc.
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

namespace Awsw\Gesi\Vistas\Asignatura;

use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Vistas\Modelo;

class Ver extends Modelo
{

	private const VISTA_NOMBRE = "Asignatura";
	private const VISTA_ID = "asignatura-ver";

	private $asignatura;

	public function __construct(int $asignatura_id)
	{
		if (Asignatura::dbExisteId($asignatura_id) {
			$this->asignatura = Asignatura::dbGet($asignatura_id);
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
			<h1>Asignatura</h1>
						
		</header>

		<section class="page-content">
			<?php

var_dump($this->asignatura);

			?>
		</section>
	</div>
</div>
		<?php

	}
}

?>