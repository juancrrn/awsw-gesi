<?php 

/**
 * Vista de grupos.
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

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Grupo;
class Lista extends Modelo
{
	private const VISTA_NOMBRE = "Grupos";
	private const VISTA_ID = "grupo-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Grupo::dbGetAll(); // TODO: recuperar el listado de grupos
	}

	public function procesa() : void
	{

		?>
		<div class="wrapper">
			<div class="container">
				<header class="page-header">
					<h1>Grupos</h1>
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