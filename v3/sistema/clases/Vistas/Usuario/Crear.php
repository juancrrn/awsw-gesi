<?php 

/**
 * Creación de un usuario.
 * 
 * - PAS: solo PAS puede acceder
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

use Awsw\Gesi\Vistas\Modelo;

class Crear extends Modelo
{

	private const VISTA_NOMBRE = "Nuevo usuario";
	private const VISTA_ID = "usuario-crear";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesa() : void
	{

		?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Nuevo usuario</h1>
		</header>

		<section class="page-content">
		
		</section>
	</div>
</div>
		<?php

	}
}

?>