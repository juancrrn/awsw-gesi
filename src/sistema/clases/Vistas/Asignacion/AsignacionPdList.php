<?php 

/**
 * Vista de las asignaciones de un usuario personal docente.
 *
 * - PD: único permitido.
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

class AsignacionPdList extends Modelo
{

    public const VISTA_NOMBRE = "Ver mis asignaciones";
    public const VISTA_ID = "asignacion-pd-list";
    
    private $listado;
    
    public function __construct()
    {
        Sesion::requerirSesionPd();
    
        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    
        $idProfesor = Sesion::getUsuarioEnSesion()->getId();

        $this->listado = Asignacion::dbGetByProfesor($idProfesor);
    }

    public function procesaContent(): void
    {
        $listaAsignaciones = $this->generaListaAsignaciones();
       
        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p>A continuación se muestra una lista con sus asignaciones.</p>
        <table id="asignacion-pd-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Participantes</th>
                </tr>
            </thead>
            <tbody>
                $listaAsignaciones
            </tbody>
        </table>
        HTML;

        echo $html;

    }

    public function generaListaAsignaciones(): string
    {   
        $app = App::getSingleton();

        $buffer = '';

        if (! empty($this->listado)) {
            foreach ($this->listado as $asignacion) {

                $horarios = $asignacion->getHorario();
                $asignatura = Asignatura::dbGet($asignacion->getAsignatura());
                $asignaturaNombre = $asignatura->getNombreCompleto();
                
                $grupo = Grupo::dbGet($asignacion->getGrupo());
                $grupoNombre = $grupo->getNombreCompleto();

                $foro = $app->getUrl() . '/mi/foros/' . $asignacion->getForoPrincipal() . '/ver/';

                $estudiantes = Usuario::dbGetEstudiantesByGrupo($grupo->getId());
                $stringEstudiantes = '';

                if (! empty($estudiantes)) {
                    for ($i = 0; $i < sizeof($estudiantes); $i++) {
                        $stringEstudiantes .= $estudiantes[$i]
                            ->getNombreCompleto();

                        if ($i == sizeof($estudiantes) - 1) {
                            $stringEstudiantes .= '.';
                        } elseif ($i == sizeof($estudiantes) - 2) {
                            $stringEstudiantes .= ' y ';
                        } else {
                            $stringEstudiantes .= ', ';
                        }
                    }
                } else{
                    $stringEstudiantes = 'No se ha encontrado ningun estudiante.';
                }
                
                $buffer .= <<< HTML
                <tr>
                    <td>
                        <a class="btn btn-primary btn-sm mx-1" href="$foro">Foro</a>
                        $asignaturaNombre
                    </td>
                    <td>$grupoNombre</td>
                    <td>$horarios</td>
                    <td><small>$stringEstudiantes</small></td>
                </tr>
                HTML;
            }
        } else {
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se ha encontrado ninguna asignación para este profesor.</td>
                <td></td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }

}

?>