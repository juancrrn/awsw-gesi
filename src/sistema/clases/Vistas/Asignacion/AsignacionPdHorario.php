<?php 

/**
 * Vista de horario completo de un profesor.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Validacion\GesiScheduleSlot;

class AsignacionPdHorario extends Modelo
{

    public const VISTA_NOMBRE = "Ver mi horario";
    public const VISTA_ID = "asignacion-pd-horario";
    
    private $listado;
    
    public function __construct()
    {
        Sesion::requerirSesionPd();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    
        $usuario = Sesion::getUsuarioEnSesion();

        $this->listado = Asignacion::dbGetByProfesor($usuario->getId());
    }

    public function procesaContent(): void
    {
        $app = App::getSingleton();
        $baseUrlForo = $app->getUrl() . '/pd/foros/';
        $autoSchedule = GesiScheduleSlot::generateAutoSchedule($this->listado, $baseUrlForo);

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p>A continuación se muestra un horario conjunto de todas las asignaturas correspondientes a tu grupo.</p>
        $autoSchedule
        HTML;

        echo $html;
    }
}

?>