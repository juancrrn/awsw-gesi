<?php 

/**
 * Vista de los integrantes de un grupo
 *
 * - PD: puede ver los integrantes del grupo del que es tutor
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

namespace Awsw\Gesi\Vistas\Grupo;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Sesion;

class MiVer extends Modelo
{

    private const VISTA_NOMBRE = "Grupo ";
    private const VISTA_ID = "grupo-ver";

    private $grupo;

    public function __construct(int $grupo_id)
    {    

        if (Grupo::dbExisteId($grupo_id)){
            $this->grupo = Grupo::dbGet($grupo_id);
        } else {
            Vista::encolaMensajeError(
                'El grupo especificado no existe.',
                '/mi/grupos/'
            );
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

        $app = App::getSingleton();
        $url_volver = $app->getUrl() . '/mi/grupos/';

        $miembros = $this->generaMiembros();

        $html = <<< HTML
        <header class="page-header">
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

    public function generaMiembros() : string
    {
        $grupo_id = $this->grupo->getId();
        $miembros = Usuario::dbGetEstudiantesByGrupo($grupo_id);

        $html = '';

        if (!empty($miembros)) {
            $app = App::getSingleton();

            foreach ($miembros as $m) {
                $nombre = $m->getNombreCompleto();

                $html .= <<< HTML
                <div class="grid-table-row">
                    <div>$nombre</div>
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
}

?>