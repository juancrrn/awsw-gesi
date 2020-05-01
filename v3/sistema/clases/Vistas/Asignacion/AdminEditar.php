<?php 

/**
 * Edición de una Asignacion.
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

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Formularios\Asignacion\AdminEditar as Formulario;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Datos\Asignacion;

class AdminEditar extends Modelo
{

	private const VISTA_NOMBRE = "Editar asignacion ";
    private const VISTA_ID = "asignacion-editar";
    
    private $form;
    private $asignacion;

	public function __construct(int $asignacion_id)
	{
        Sesion::requerirSesionPs();
        
        if (Asignacion::dbGet($asignacion_id)) {
			$this->asignacion = Asignacion::dbGet($asignacion_id);
		} else {
			Vista::encolaMensajeError(
				'La Asignacion especificada no existe.',
				'/admin/asignaturas/'
			);
		}

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = $asignacion_id;

        $this->form = new Formulario("/admin/asignaciones/$asignacion_id/editar/", $this->asignacion); 
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