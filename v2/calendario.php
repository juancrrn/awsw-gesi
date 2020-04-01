<?php

/**
 * Vistas de calendario.
 *
 * - PDI: puede editar todos los calendarios.
 * - PD: puede editar los calendarios de sus asignaturas.
 * - Estudiantes: pueden ver el calendario de sus asignaturas.
 * - Resto: pueden ver el calendario público.
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

require_once __DIR__ . "/sistema/configuracion.php";

use \Awsw\Gesi\Vistas\Vista;

Vista::setPaginaActual("Calendario", "calendario");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Calendario</h1>
		</header>

		<section class="page-content">
			...
		</section>
	</div>
</div>
<?php

Vista::incluirPie();
