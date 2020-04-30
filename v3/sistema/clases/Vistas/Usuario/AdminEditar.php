<?php 

/**
 * Vista de edición de un usuario en particular.
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
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;

class AdminEditar extends Modelo
{

	private const VISTA_NOMBRE = "Editar a ";
	private const VISTA_ID = "usuario-editar";

	private $usuario;

	public function __construct(int $usuario_id)
	{
		Sesion::requerirSesionPs();

		if (Usuario::dbExisteId($usuario_id)) {
			$this->usuario = Usuario::dbGet($usuario_id);
		} else {
			Vista::encolaMensajeError(
				'El usuario especificado no existe.',
				'/admin/usuarios/'
			);
		}

		$this->nombre = self::VISTA_NOMBRE . $this->usuario->getNombreCompleto();
		$this->id = self::VISTA_ID;
	}

	public function procesaContent() : void
	{

		// TODO: Rellenar formulario con $this->usuario

		$html = <<< HTML
					<header class="page-header">
						<h1>$this->nombre</h1>
					</header>

					<section class="page-content">
						Aquí el formulario.
					</section>

HTML;

		echo $html;

	}
}

?>