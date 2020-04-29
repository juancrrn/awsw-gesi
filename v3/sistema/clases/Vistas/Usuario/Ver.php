<?php 

/**
 * Vista de datos de un usuario en particular.
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

namespace Awsw\Gesi\Vistas\Usuario;

use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Vistas\Modelo;

class Ver extends Modelo
{

	private const VISTA_NOMBRE = "Usuario";
	private const VISTA_ID = "usuario-ver";

	private $usuario;

	public function __construct(int $usuario_id)
	{
		if (false) { // TODO: Comprobar que el id recibido existe
			$this->usuario = Usuario::dbGet($usuario_id);
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
			<h1>Usuario</h1>
		</header>

		<section class="page-content">
			<?php

var_dump($this->usuario);

			?>
		</section>
	</div>
</div>
		<?php

	}
}

?>