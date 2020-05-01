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

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Vista;

use Awsw\Gesi\Formularios\Asignacion\AdminEliminar as Formulario;


class AdminEliminar extends Modelo{

    private const VISTA_NOMBRE = "Eliminar Asignacion "; // TODO
    private const VISTA_ID = "asignacion-eliminar";
    
    private $asignacion;
    private $form;

    public function __construct(int $asignacion_id){

        Sesion::requerirSesionPs();

        if(Asignacion::dbGet($asignacion_id)){
            $this->asignacion = Asignacion::dbGet($asignacion_id);
        }else{
			Vista::encolaMensajeError('La asignacion especificada no existe.', '/admin/asignaciones');
        }
        
        $this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
		$this->form = new Formulario("/admin/asignaciones/$asignacion_id/eliminar/", $asignacion_id);

        $this->form->gestiona();
    }

    public function procesaContent() : void {

        $formulario = $this->form->getHtml();

        $html = <<< HTML
            <header class= "page-header">
                <h1>$this->nombre</h1>
            </header>

        <section class="page-content">
            $formulario;
        </section>

HTML;
        echo $html;
    }


}
