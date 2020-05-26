<?php 

/**
 * TODO: NOMBRE DE LA CLASE
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

namespace Awsw\Gesi\Vistas\Grupo;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Vista;

use Awsw\Gesi\Formularios\Grupo\AdminEditar as Formulario;


class AdminEditar extends Modelo
{
	private const VISTA_NOMBRE = "Editar grupo ";// TODO completar nombre
	private const VISTA_ID = "grupo-admin-editar";

	private $grupo;
	private $formulario;

	public function __construct(int $grupo_id)
	{
		Sesion::requerirSesionPs();

		if (Grupo::dbExisteId($grupo_id)) {
				$this->grupo = Grupo::dbGet($grupo_id);

		} else {
			Vista::encolaMensajeError('El grupo especificado no existe', '/admin/grupos/');
		}

		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
		$this->formulario = new Formulario("/admin/grupos/$grupo_id/editar/", $this->grupo->getId(), $this->grupo);
		$this->formulario->gestiona();
	}

	public function procesaContent() : void 
	{

			$form = $this->formulario->getHtml();
		$html = <<< HTML
		<header class="page-header">
			<h1>$this->nombre</h1>
		</header>

		<section class="page-content">
			<p>$form</p>
		</section>

HTML;

		echo $html;

	}
}

?>