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

require_once __DIR__ . "/sistema/configuracion.php";

use \Awsw\Gesi\Vistas\Vista;

Vista::setPaginaActual("Biblioteca", "biblioteca");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Biblioteca</h1>
		</header>

		<section class="page-content">
			...
		</section>
	</div>
</div>
<?php

Vista::incluirPie();
