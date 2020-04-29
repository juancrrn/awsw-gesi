<?php 

/**
 * Vista de biblioteca.
 *
 * - PAS: puede añadir libros y asociarlos a asignaturas.
 * - Registrados: pueden solicitar y reservar libros.
 * - Cualquiera: puede ver los libros disponibles.
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

class General extends Modelo
{
	private const VISTA_NOMBRE = "Biblioteca";
	private const VISTA_ID = "biblioteca-general";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = array(); // TODO: recuperar el listado de la biblioteca
	}

	public function procesa() : void
	{

		?>
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Biblioteca</h1>
				</header>
		
				<section class="page-content">
					<?php

var_dump($this->listado);

					?>
				</section>
			</div>
		</div>
		<?php

	}
}

?>