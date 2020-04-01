<?php

/**
 * Vista de inicio de sesión.
 *
 * Invitado (cualquiera): puede iniciar sesión.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundar
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

require_once __DIR__ . "/sistema/configuracion.php";

use \Awsw\Gesi\App;
use \Awsw\Gesi\Vistas\Vista;
use \Awsw\Gesi\Formularios\Sesion\Login as FormularioSesionLogin;

Vista::setPaginaActual("Iniciar sesión", "login");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Iniciar sesión</h1>
		</header>

		<section class="page-content">
			<?php

$form = new FormularioSesionLogin(); 
$form->gestiona();

			?>
		</section>
	</div>
</div>
<?php

Vista::incluirPie();