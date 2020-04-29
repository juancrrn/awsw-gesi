<?php

/**
 * Vista de recuperación de contraseña.
 *
 * - Invitado (cualquiera): puede recuperar su contraseña.
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

namespace Awsw\Gesi\Vistas\Sesion;

use \Awsw\Gesi\Vistas\Modelo;

class RestablecerContrasena implements Modelo
{
	public const NOMBRE = "Restablecer contraseña";
	public const ID = "sesion-restablecer-contrasena";

	public static function genera() : void
	{

		?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Recuperar contraseña</h1>
		</header>

		<section class="page-content">
			...
		</section>
	</div>
</div>
<?php

	}
}

?>