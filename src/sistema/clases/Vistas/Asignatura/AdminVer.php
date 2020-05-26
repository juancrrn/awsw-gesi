<?php 

/**
 * Vista de una asignatura en particular.
 *
 * - PAS: puede editar la asignatura (información, datos, etc.).
 * - PD: puede publicar en el foro y así añadir recursos, etc.
 * - Estudiante: puede ver los foros etc.
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

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Sesion;

class AdminVer extends Modelo
{

    private const VISTA_NOMBRE = "Asignatura ";
    private const VISTA_ID = "asignatura-ver";

    private $asignatura;

    public function __construct(int $asignatura_id)
    {    
        Sesion::requerirSesionPs();

        if (Asignatura::dbExisteId($asignatura_id)){
            $this->asignatura = Asignatura::dbGet($asignatura_id);
        } else {
            Vista::encolaMensajeError(
                'La Asignatura especificada no existe.',
                '/admin/asignaturas/'
            );
        }

        $this->nombre = self::VISTA_NOMBRE . $this->asignatura->getNombreCompleto();
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {
        $nombre_completo = $this->asignatura->getNombreCompleto();
        $nombre_corto = $this->asignatura->getNombreCorto();
        $nivel = $this->asignatura->getNivel();
        $curso_escolar = $this->asignatura->getCursoEscolar();

        $app = App::getSingleton();
        $url_volver = $app->getUrl() . '/admin/asignaturas/';

        $lista = $this->generaAsignaciones();

        $html = <<< HTML
        <header class="page-header">
            <p class="page-back-button"><a href="$url_volver">Volver a Asignaturas</a></p>
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
            
            <h2>Asignaciones a grupos y profesores</h2>
            
            <p>Esta asignatura se imparte en los siguientes grupos por los siguientes profesores:</p>
            
            <div id="asignatura-admin-ver-asignacion-lista" class="grid-table">
                <div class="grid-table-header">
                    <div class="grid-table-row">
                        <div></div>
                        <div>Grupo</div>
                        <div>Profesor</div>
                        <div>Horario</div>
                    </div>
                </div>
                <div class="grid-table-body">
                    $lista
                </div>
            </div>
        </section>

        HTML;
    
        echo $html;
    
    }

    public function generaAsignaciones() : string
    {
        $asignatura_id = $this->asignatura->getId();
        $asignaciones = Asignacion::dbGetByAsignatura($asignatura_id);

        $html = '';

        if (!empty($asignaciones)) {
            foreach ($asignaciones as $a) {
                $grupo = Grupo::dbGet($a->getGrupo());
                $corto_grupo = $grupo->getNombreCorto();
                $completo_grupo = $grupo->getNombreCompleto();
                $profesor = Usuario::dbGet($a->getProfesor());
                $nombre_profesor = $profesor->getNombreCompleto();
                $horario = $a->getHorario();

                $html .= <<< HTML
                <div class="grid-table-row">
                    <div>$corto_grupo</div>
                    <div>$completo_grupo</div>
                    <div>$nombre_profesor</div>
                    <div>$horario</div>
                </div>

                HTML;
            }
        }else{
            $html .= <<< HTML
            <div class="grid-table-row-empty">
                No se han encontrado asignaciones de esta asignatura.
            </div>

            HTML;
        }

        return $html;
    }

    public function procesaSide(): void
    {
        $app = App::getSingleton();
        $asignatura_id = $this->asignatura->getId();
        $url_editar = $app->getUrl() . "/admin/asignaturas/$asignatura_id/editar/";

        $html = <<< HTML
        <ul>
            <li><a href="$url_editar" class="btn">Editar asignatura</a></li>
        </ul>

        HTML;

        echo $html;
    }
}

?>