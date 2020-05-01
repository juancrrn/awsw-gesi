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

use Awsw\Gesi\Formularios\Usuario\AdminEliminar as Formulario;

class AdminEliminar extends Modelo
{

	private const VISTA_NOMBRE = "Eliminar a ";
	private const VISTA_ID = "usuario-eliminar";

	private $usuario;
	private $form;
	
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
		$this->form = new Formulario("/admin/usuarios/$usuario_id/eliminar/", $this->usuario->getNombreCompleto(), $this->usuario->getId()); 
		
		$this->form->gestiona();
	}

	public function procesaContent() : void
	{
		$formulario = $this->form->getHtml();

		$html = <<< HTML
				
					<header class="page-header">
						<h1>$this->nombre</h1>
					</header>

					<section class="page-content">
						$formulario
					</section>

HTML;

		echo $html;

	}
}

?>