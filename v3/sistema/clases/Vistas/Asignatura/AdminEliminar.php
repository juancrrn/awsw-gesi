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

namespace Awsw\Gesi\Vistas\Asignatura;

use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Vista;

use Awsw\Gesi\Formularios\Asignatura\AdminEliminar as Formulario;


class AdminEliminar extends Modelo{

    private const VISTA_NOMBRE = "Eliminar Asignatura "; // TODO
    private const VISTA_ID = "asignatura-eliminar";
    
    private $asigantura;
    private $form;

    public function __construct(int $asignatura_id){

        Sesion::requerirSesionPs();

        if(Asignatura::dbExisteId($asignatura_id)){
            $this->asignatura = Asignatura::dbGet($asignatura_id);
        }else{
			Vista::encolaMensajeError('La asignatura especificada no existe.', '/admin/grupos');
        }
        
        $this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
		$this->form = new Formulario("/admin/asignaturas/$asignatura_id/eliminar/", $this->asignatura->getId(), $this->asignatura->getNombreCorto());

        $this->form->gestiona();
    }

    public function procesaContent() : void {

        $formulario = $this->form->getHtml();

        $html = <<< HTML
            <header class= "page-header">
                <h1>$this->nombre;</h1>
            </header>

        <section class="page-content">
            $formulario;
        </section>

HTML;
        echo $html;
    }


}
