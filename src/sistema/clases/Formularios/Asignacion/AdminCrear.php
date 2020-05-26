<?php

/**
 * Gesión del formulario de creación de Asignacion
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

namespace Awsw\Gesi\Formularios\Asignacion;

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Asignacion;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Vistas\Vista;

class AdminCrear extends Formulario
{
    public function __construct(string $action){
        parent::__construct('form-asignatura-crear', array('action' => $action));
    }

    protected function generaCampos(array & $datos_iniciales = array()) : void
    {

        $profesor = isset($datos_iniciales['profesor']) ?
        $datos_iniciales['profesor'] : '';

        //Mostrar todos los profesores
        $profesores = Usuario::dbGetByRol(2);

        $profesor_options = '';

        foreach ($profesores as $p) {
            $id = $p->getId();
            $nombre = $p->getNombreCompleto();
            $selected = $id == $profesor ? ' selected="selected"' : '';

            $profesor_options .= <<< HTML
            <option value="$id" $selected>$nombre</option>

            HTML;
        }

        $grupo = isset($datos_iniciales['grupo']) ? 
        $datos_iniciales['grupo'] : '';


        //Mostrar todos los grupos
        $grupos = Grupo::dbGetAll();
        $grupo_options = '';
        foreach($grupos as $g){
            $id = $g->getId();
            $nombre = $g->getNombreCompleto();
            $selected = $id == $grupo ? 'selected="selected"' : '';

            $grupo_options.= <<< HTML
        <option value="$id" $selected>$nombre</option>
        
HTML;
        }

$asignatura = isset($datos_iniciales['asignatura']) ? 
$datos_iniciales['asignatura'] : '';


//Mostrar todos los grupos
$asignaturas = Asignatura::dbGetAll();
$asignatura_options = '';
foreach($asignaturas as $a){
    $id = $a->getId();
    $nombre = $a->getNombreCompleto();
    $selected = $id == $asignatura ? 'selected="selected"' : '';

    $asignatura_options.= <<< HTML
    <option value="$id" $selected>$nombre</option>
      
HTML;
    }

        $horario = isset($datos_iniciales['horario']) ?
        $datos_iniciales['horario'] : '';


            $this->html .= <<< HTML

        <div class="form-group">
            <label for="profesor">Profesor</label>
            <select class="form-control" name="profesor" id="profesor" required="required">
                <option value="" selected disabled>Selecciona...</option>
                $profesor_options
            </select>
        </div>

        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select class="form-control" name="grupo" id="grupo" required="required">
                <option value="" selected disabled>Selecciona...</option>
                $grupo_options
            </select>
        </div>


        <div class="form-group">
            <label for="asignatura">Asignatura</label>
            <select class="form-control" name="asignatura" id="asignatura" required="required">
                <option value="" selected disabled>Selecciona...</option>
                $asignatura_options
            </select>
        </div>

        <div class="form-group">
            <label for="horario">Horario</label>
            <input class="form-control" type="text" name="horario" id="horario" value="$horario" placeholder="horario" required="required" />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Crear</button>
        </div>

HTML;

    }

    protected function procesa(array & $datos) : void
    {

        $profesor = isset($datos['profesor']) ?
            $datos['profesor'] : null;

        $grupo = isset($datos['grupo']) ?
            $datos['grupo'] : null;

        $asignatura = isset($datos['asignatura']) ?
            $datos['asignatura'] : null;
        
        $horario = isset($datos['horario']) ?
            $datos['horario'] : null;

        /*
         * Comprobar que el nivel no está vacío y que es un valor admitido.
         * 
         * TODO: log si pasa algo que no nos gusta
         */

        if (empty($profesor) || ! Usuario::dbExisteId($profesor)) {
            Vista::encolaMensajeError('El campo profesor no puede ser vacío.');
        }

        if (empty($grupo) || ! Grupo::dbExisteId($grupo)) {
            Vista::encolaMensajeError('El campo grupo no puede ser vacío.');
        }

        if (empty($asignatura) || ! Asignatura::dbExisteId($asignatura)) {
            Vista::encolaMensajeError('El campo asignatura no puede ser vacío.');
        }
        if (empty($horario)) {
            Vista::encolaMensajeError("El campo nombre corto es obligatorio.");
		} elseif (!Valido::testCadenaB($horario)){
            Vista::encolaMensajeError("El campo nombre corto no es válido.");
        }

        /*
         * Si no hay ningún error, continuar.
         */
        
        if (! Vista::hayMensajesError()) {
            $asignacion = new Asignacion(
                null,
                $asignatura,
                $grupo,
                $profesor,
                $horario,
                null
            );

            $asignacion_id = $asignacion->dbInsertar();

            if ($asignacion_id) {
                Vista::encolaMensajeExito('Asignacioncreada correctamente.', "/admin/asignaciones/");
            } else {
                Vista::encolaMensajeError('Hubo un error al crear la asignacion.');
            }
        }

        $this->genera($datos);
    }
}

?>