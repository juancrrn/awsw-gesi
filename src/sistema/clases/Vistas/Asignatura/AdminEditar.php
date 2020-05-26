<?php 

/**
 * Edición de una Asignatura.
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

namespace Awsw\Gesi\Vistas\Asignatura;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Formularios\Asignatura\AdminEditar as Formulario;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Datos\Asignatura;

class AdminEditar extends Modelo
{

	private const VISTA_NOMBRE = "Editar asignatura ";
    private const VISTA_ID = "asignatura-editar";
    
    private $form;
    private $asignatura;

	public function __construct(int $asignatura_id)
	{
        Sesion::requerirSesionPs();
        
        if (Asignatura::dbGet($asignatura_id)) {
			$this->asignatura = Asignatura::dbGet($asignatura_id);
		} else {
			Vista::encolaMensajeError(
				'La Asignatura especificada no existe.',
				'/admin/asignaturas/'
			);
		}

        $this->nombre = self::VISTA_NOMBRE . $this->asignatura->getNombreCompleto();
        $this->id = self::VISTA_ID;

        $this->form = new Formulario("/admin/asignaturas/$asignatura_id/editar/", $this->asignatura); 
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