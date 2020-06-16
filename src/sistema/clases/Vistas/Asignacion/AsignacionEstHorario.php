<?php 

/**
 * TODO
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
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Vistas\Asignacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Validacion\GesiScheduleSlot;
use stdClass;

class AsignacionEstHorario extends Modelo
{

    public const VISTA_NOMBRE = "Ver mi horario";
    public const VISTA_ID = "asignacion-est-horario";
    
    private $listado;
    
    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    
        $usuario = Sesion::getUsuarioEnSesion();

        if($usuario->getGrupo() !== null){
            $this->listado = Asignacion::dbGetByGrupo($usuario->getGrupo());
        }
    }

    public function procesaContent(): void
    {
        $horarioJson = htmlspecialchars($this->generaHorarioJson());

        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p>A continuación se muestra un horario conjunto de todas las asignaturas correspondientes a tu grupo.</p>
        <div class="gesi-schedule" data-autolaunch="true" data-json="$horarioJson"></div>
        HTML;

        echo $html;

    }

    public function generaHorarioJson(): string
    {
        $app = App::getSingleton();

        $buffer = array();

        if (! empty($this->listado)) {
            foreach ($this->listado as $asignacion) {
                $asignatura = Asignatura::dbGet($asignacion->getAsignatura());
                $profesor = Usuario::dbGet($asignacion->getProfesor());

                $buffer = array_merge(
                    $buffer,  
                    GesiScheduleSlot::convierteGesiSchedule(
                        $asignacion->getHorario(),
                        $asignatura->getNombreCorto(),
                        $profesor->getNombreCompleto(),
                        $app->getUrl() . '/est/foros/' . $asignacion->getForoPrincipal() . '/'
                    )
                );
            }
        }

        //var_dump($buffer);

        return json_encode($buffer);
    }

}