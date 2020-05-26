<?php

/**
 * Gesión del formulario de creación de Asignatura
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

namespace Awsw\Gesi\Formularios\Asignatura;

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Vistas\Vista;

class AdminCrear extends Formulario
{
    public function __construct(string $action){
        parent::__construct('form-asignatura-crear', array('action' => $action));
    }

    protected function generaCampos(array & $datos_iniciales = array()) : void
    {

        $nivel = isset($datos_iniciales['nivel']) ?
        $datos_iniciales['nivel'] : '';
        
        /*
        * Listar las opciones de nivel.
        */
            
        $nivel_options = '';

        foreach (Valido::getNiveles() as $raw => $valor) {
            $selected = $raw == $nivel ? ' selected="selected"' : '';
            $corto = $valor['corto'];

            $nivel_options .= <<< HTML
<option value="$raw" $selected>$corto</option>

HTML;
        }

        $curso_escolar = isset($datos_iniciales['curso_escolar']) ? 
            $datos_iniciales['curso_escolar'] : '';
        
        $nombre_corto = isset($datos_iniciales['nombre_corto']) ?
            $datos_iniciales['nombre_corto'] : '';

        $nombre_completo = isset($datos_iniciales['nombre_completo']) ?
            $datos_iniciales['nombre_completo'] : '';


        $this->html .= <<< HTML

<div class="form-group">
    <label for="nivel">Nivel</label>
    <select class="form-control" name="nivel" id="nivel" required="required">
        <option value="" selected disabled>Selecciona...</option>
        $nivel_options
    </select>
</div>

<div class="form-group">
    <label for="curso_escolar">Curso escolar</label>
    <p class="form-help">Introduce el año de inicio del curso escolar. Por ejemplo, para el curso 2018 - 2019, introduce 2018.</p>
    <input class="form-control" type="number" name="curso_escolar" id="curso_escolar" value="$curso_escolar" placeholder="Curso escolar" required="required">
</div>

<div class="form-group">
    <label for="nombre_corto">Nombre corto</label>
    <input class="form-control" type="text" name="nombre_corto" id="nombre_corto" value="$nombre_corto" placeholder="Nombre corto" required="required" />
</div>

<div class="form-group">
    <label for="nombre_completo">Nombre completo</label>
    <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" value="$nombre_completo" placeholder="Nombre completo" required="required" />
</div>

<div class="form-actions">
    <button type="submit" class="btn">Crear</button>
</div>

HTML;

    }

    protected function procesa(array & $datos) : void
    {

        $nivel = isset($datos['nivel']) ?
            $datos['nivel'] : null;

        $curso_escolar = isset($datos['curso_escolar']) ?
            $datos['curso_escolar'] : null;

        $nombre_corto = isset($datos['nombre_corto']) ?
            $datos['nombre_corto'] : null;
        
        $nombre_completo = isset($datos['nombre_completo']) ?
            $datos['nombre_completo'] : null;

        /*
         * Comprobar que el nivel no está vacío y que es un valor admitido.
         * 
         * TODO: log si pasa algo que no nos gusta
         */

        if (empty($nivel) || ! Valido::testNivelRaw($nivel)) {
            Vista::encolaMensajeError('El campo nivel no es válido.');
        }

        if (empty($curso_escolar)) {
            Vista::encolaMensajeError('El campo curso escolar no puede estar vacío.');
        } elseif (! Valido::testStdInt($curso_escolar)) {
            Vista::encolaMensajeError('El campo curso escolar no es válido.');
        }

        if (empty($nombre_corto)) {
            Vista::encolaMensajeError("El campo nombre corto es obligatorio.");
        } elseif(empty($nombre_completo)) {
			Vista::encolaMensajeError("El campo nombre completo es obligatorio.");
		} elseif (!Valido::testCadenaB($nombre_corto)){
            Vista::encolaMensajeError("El campo nombre corto no es válido.");
        }

        /*
         * Si no hay ningún error, continuar.
         */
        
        if (! Vista::hayMensajesError()) {
            $asignatura = new Asignatura(
                null,
                $nivel,
                $curso_escolar,
                $nombre_corto,
                $nombre_completo

            );

            $asignatura_id = $asignatura->dbInsertar();

            if ($asignatura_id) {
                Vista::encolaMensajeExito('Asignatura creada correctamente.', "/admin/asignaturas/");
            } else {
                Vista::encolaMensajeError('Hubo un error al crear la asignatura.');
            }
        }

        $this->genera($datos);
    }
}

?>