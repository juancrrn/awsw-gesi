<?php 

/**
 * Vista de movimientos personales en la biblioteca.
 *
 * - Registrados: pueden ver sus movimientos en la biblioteca.
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

namespace Awsw\Gesi\Vistas\Biblioteca;

use Awsw\Gesi\Vistas\Modelo;

class Movimientos extends Modelo
{
	private const VISTA_NOMBRE = "Mis movimientos en la biblioteca";
	private const VISTA_ID = "biblioteca-movimientos";

	private $movimientos;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->movimientos = array(); // TODO: recuperar movimientos del usuario
	}

	public function procesa() : void
	{

		?>
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Mis movimientos en la biblioteca</h1>
				</header>
		
				<section class="page-content">
					<?php

var_dump($this->movimientos);

					?>
				</section>
			</div>
		</div>
		<?php

	}
}

?>