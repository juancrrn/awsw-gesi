<?php

/**
 * Vista de inicio de sesión.
 *
 * Invitado (cualquiera): puede iniciar sesión.
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

use \Awsw\Gesi\App;
use \Awsw\Gesi\Vista;

Vista::setPaginaActual("Iniciar sesión", "login");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Iniciar sesión</h1>
		</header>

		<section class="page-content">
			<form action="<?php App::getSingleton()->getUrl(); ?>/login.php">
				<div class="form-group">
					<label for="login-nif-nie">NIF o NIE</label>
					<input type="text" name="login-nif-nie" id="login-nif-nie" placeholder="NIF o NIE" required="required">
				</div>
				
				<div class="form-group">
					<label for="login-password">Contraseña</label>
					<input type="text" name="login-password" id="login-password" placeholder="Contraseña" required="required">
				</div>

				<div class="form-group">
					<button type="submit">Continuar</button>
				</div>
			</form>
		</section>
	</div>
</div>
<?php

Vista::incluirPie();