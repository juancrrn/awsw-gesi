<?php 

/**
 * Vista de las asignaciones de un usuario estudiante.
 *
 * - Estudiante, unico permitido.
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

use Awsw\Gesi\App;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;

class AsignacionEstList extends Modelo
{

    public const VISTA_NOMBRE = "Ver mis asignaciones";
    public const VISTA_ID = "asignacion-Est-list";
    
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

    public function procesaContent() : void
    {   
        $listaAsignaciones = $this->generaListaAsignaciones();
       
        $html = <<< HTML
        <h2 class="mb-4">$this->nombre</h2>
        <p>A continuación se muestra una lista con sus asignaciones.</p>
        <table id="asignacion-pd-list" class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th scope="col">Horario</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Foro</th>
                </tr>
            </thead>
            <tbody>
                $listaAsignaciones
            </tbody>
        </table>
        HTML;

        echo $html;

    }

    public function generaListaAsignaciones() : string
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
                
                $buffer .= <<< HTML
                <tr>
                    <td data-col-name="horario">$horarios</td>
                    <td data-col-name="asignaturaNombre">$asignaturaNombre</td>
                    <td data-col-name="grupoNombre">$grupoNombre</td>
                    <td data-col-name="foroNombre"><a href="$foro">Ir al foro</a></td>
                </tr>
                HTML;
            }
        } else {
            $buffer .= <<< HTML
            <tr>
                <td></td>
                <td>No se ha encontrado ninguna asignación.</td>
                <td></td>
                <td></td>
            </tr>
            HTML;
        }

        return $buffer;
    }

}