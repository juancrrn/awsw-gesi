<?php 

/**
 * Vista de un grupo en particular.
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

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Datos\Usuario;

class AdminVer extends Modelo
{

    private const VISTA_NOMBRE = "Grupo ";
    private const VISTA_ID = "grupo-ver";

    private $grupo;

    public function __construct(int $grupo_id)
    {

        Sesion::requerirSesionPs();

        if (Grupo::dbExisteId($grupo_id)) {
            $this->grupo = Grupo::dbGet($grupo_id);
        } else {
            Vista::encolaMensajeError('El grupo especificado no existe.', '/admin/grupos/');
            
        }

        $this->nombre = self::VISTA_NOMBRE . $this->grupo->getNombreCompleto();
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {
        $nombre_completo = $this->grupo->getNombreCompleto();
        $nombre_corto = $this->grupo->getNombreCorto();
        $nivel = $this->grupo->getNivel();
        $curso_escolar = $this->grupo->getCursoEscolar();

        $tutor = Usuario::dbGet($this->grupo->getTutor())->getNombreCompleto();

        $app = App::getSingleton();
        $url_volver = $app->getUrl() . '/admin/asignaturas/';

        $asignaciones = $this->generaAsignaciones();
        $miembros = $this->generaMiembros();
    
        $html = <<< HTML
        <header class ="page-header">
            <p class="page-back-button"><a href="$url_volver">Volver a Grupos</a></p>
            <h1>$nombre_completo</h1>
        </header>
        
        <section class="page-content">
            <div class="data-field-wrapper">
                <div class="data-field">
                    <span class="label">Nombre corto</span>
                    <span class="value">$nombre_corto</span>
                </div>
                <div class="data-field">
                    <span class="label">Nivel</span>
                    <span class="value">$nivel</span>
                </div>
                <div class="data-field">
                    <span class="label">Curso</span>
                    <span class="value">$curso_escolar</span>
                </div>
            </div>
            
            <h2>Tutor</h2>
            
            <div class="data-field-wrapper">
                <div class="data-field">
                    <span class="label">Tutor</span>
                    <span class="value">$tutor</span>
                </div>
            </div>
        
            <h2>Asignaciones de asignaturas y profesores</h2>
            
            <p>En este grupo se imparten las siguientes asignaturas por los siguientes profesores:</p>
            
            <div id="grupo-admin-ver-asignacion-lista" class="grid-table">
                <div class="grid-table-header">
                    <div class="grid-table-row">
                        <div></div>
                        <div>Asignatura</div>
                        <div>Profesor</div>
                        <div>Horario</div>
                    </div>
                </div>
                <div class="grid-table-body">
                    $asignaciones
                </div>
            </div>
            
            <h2>Estudiantes miembros</h2>
            
            <div id="grupo-admin-ver-miembros-lista" class="grid-table">
                <div class="grid-table-header">
                    <div class="grid-table-row">
                        <div>Nombre</div>
                    </div>
                </div>
                <div class="grid-table-body">
                    $miembros
                </div>
            </div>
        </section>

        HTML;

        echo $html;        
    }

    public function generaAsignaciones() : string
    {
        $grupo_id = $this->grupo->getId();
        $asignaciones = Asignacion::dbGetByGrupo($grupo_id);

        $html = '';

        if (!empty($asignaciones)) {
            $app = App::getSingleton();

            foreach ($asignaciones as $a) {
                $asignatura = Asignatura::dbGet($a->getAsignatura());
                $corto_asignatura = $asignatura->getNombreCorto();
                $completo_asignatura = $asignatura->getNombreCompleto();
                $profesor = Usuario::dbGet($a->getProfesor());
                $nombre_profesor = $profesor->getNombreCompleto();
                $horario = $a->getHorario();

                $url_ver_asignatura = $app->getUrl() . "/admin/asignaturas/" . $a->getAsignatura() . "/ver/";
                $url_ver_profesor = $app->getUrl() . "/admin/usuarios/" . $a->getProfesor() . "/ver/";

                $html .= <<< HTML
                <div class="grid-table-row">
                    <div><a href="$url_ver_asignatura">$corto_asignatura</a></div>
                    <div><a href="$url_ver_asignatura">$completo_asignatura</a></div>
                    <div><a href="$url_ver_profesor">$nombre_profesor</a></div>
                    <div>$horario</div>
                </div>

                HTML;
            }
        } else {
            $html .= <<< HTML
            <div class="grid-table-row-empty">
                No se han encontrado asignaciones en este grupo.
            </div>

            HTML;
        }

        return $html;
    }

    public function generaMiembros() : string
    {
        $grupo_id = $this->grupo->getId();
        $miembros = Usuario::dbGetEstudiantesByGrupo($grupo_id);

        $html = '';

        if (!empty($miembros)) {
            $app = App::getSingleton();

            foreach ($miembros as $m) {
                $nombre = $m->getNombreCompleto();
                $url_ver = $app->getUrl() . '/admin/usuarios/' . $m->getId() . '/ver/';

                $html .= <<< HTML
                <div class="grid-table-row">
                    <div><a href="$url_ver">$nombre</a></div>
                </div>

                HTML;
            }
        }else{
            $html .= <<< HTML
            <div class="grid-table-row-empty">
                No se han encontrado miembros de este grupo.
            </div>

            HTML;
        }

        return $html;
    }

    public function procesaSide() : void
    {
        $app = App::getSingleton();
        $grupo_id = $this->grupo->getId();
        $url_editar = $app->getUrl() . "/admin/grupos/$grupo_id/editar/";

        $html = <<< HTML
        <ul>
            <li><a href="$url_editar" class="btn">Editar grupo</a></li>
        </ul>

        HTML;

        echo $html;
    }
}

?>