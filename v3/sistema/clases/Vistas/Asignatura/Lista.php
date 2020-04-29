<?php 

/**
 * Vista de asignaturas.
 *
 * - PAS: puede editar todas las asignaturas.
 * - PD: puede ver las asignaturas que tiene asignadas.
 * - Estudiante: puede ver las asignaturas en las que está matriculado.
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

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignatura;
use \Awsw\Gesi\Sesion;
class Lista extends Modelo
{
	private const VISTA_NOMBRE = "Asignaturas";
	private const VISTA_ID = "asignaturas-lista";

	private $listado;

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;

		$this->listado = Asignatura::dbGetAll();
	}

	public function procesaAntesDeLaCabecera(): void
	{
		Sesion::requerirSesionPs();
	}

	public function procesa() : void {

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Asignaturas</h1>
		</header>

		<section class="page-content">
			<p>A conticuación se muestra una lista con las asignaturas.</p>
			<?php


//Comprobar si hay asignaturas

if(Asignatura::dbAny()){
			?><div id="asignatura-lista"><?php
	$asignaturas = Asignatura::dbGetAll();

	foreach($asignaturas as $asignatura){
		?>
		<article class="asignatura">
			<header>
				<p class="from"><?php echo '<strong>' . $asignatura->getNombreLargo() . '</strong>' ?> </p>
				</header>
			<section class="content">
				<?php echo $asignatura->getCurso(); ?>
			</section>
	</article>
	}
}

		</section>
	</div>
</div>
<?php

	}
}else{

	?><p>En estos momentos no hay ninguna asignatura</p><?php
}

					?>
			</section>
		</div>
	</div>
	<?php
	}
}
?>