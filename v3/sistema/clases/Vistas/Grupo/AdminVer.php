<?php 

/**
 * Vista de un grupo en particular.
 *
 * - PAS: único permitido.
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

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Vistas\Modelo;

class AdminVer extends Modelo
{

	private const VISTA_NOMBRE = "Grupo";
	private const VISTA_ID = "grupo-ver";

	private $foro;

	public function __construct(int $grupo_id)
	{
		if (false) { // TODO: Comprobar que el id recibido existe
			$this->foro = Grupo::dbGet($grupo_id);
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
			<h1>Grupo</h1>
		</header>

		<section class="page-content">
			<?php

var_dump($this->grupo);

			?>
		</section>
	</div>
</div>
		<?php

	}
}

?>