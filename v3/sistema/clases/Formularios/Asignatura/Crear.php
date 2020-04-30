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

class Crear extends Formulario{
    public function __construct(string $action){
        parent::__construct('form-asignatura-crear', array('action' => $action));
    }

    protected function generaCampos(array & $datos_iniciales = array()) : void{

        $curso_escolar = isset($datos_iniciales['curso_escolar']) ? 
            $datos_iniciales['curso_escolar'] : '';
        
        $nombre_corto = isset($datos_iniciales['nombre_corto']) ?
            $datos_iniciales['nombre_corto'] : '';

        $nombre_completo = isset($datos_iniciales['nombre_completo']) ?
            $datos_iniciales['nombre_completo'] : '';


        $this->html .= <<< HTML
    <div class=form-group>
        <label>CURSO</label>

        <select class="form-control" name="curso" id="curso" required="required">
            <option value="" selected disabled>Selecciona...</option>
            <option value="Primero_ESO"> Primero ESO</option>
            <option value="Segundo_ESO"> Segundo ESO</option>
            <option value="Tercero_ESO"> Tercero ESO</option>
            <option value="Cuarto_ESO"> Cuarto ESO</option>
            <option value="Primero_BACH"> Primero BACH</option>
            <option value="Segundo_BACH"> Segundo BACH</option>
        </select>
    </div>

    <div class="form-actions" >
        <button type="submit" class="btn">Crear</button>
    </div>

HTML;

    }



    protected function procesa(array & $datos) : void{


        $nombre_corto = isset($datos['nombre_corto']) ?
            $datos['nombre_corto'] : null;
        
        $nombre_completo = isset($datos['nombre_completo']) ?
            $datos['nombre_completo'] : null;


        if (empty($nombre_corto)) {
            Vista::encolaMensajeError("El campo nombre corto es obligatorio.");
        } else{
            if(!Valido::testStdString($nombre_completo)){
                Vista::encolaMensajeError("El campo nombre completo no es válido.");
			}
		}
			
		if (empty($nombre_completo)) {
			Vista::encolaMensajeError("El campo nombre completo es obligatorio.");
		} else{
            if(!Valido::testStdString($nombre_corto)){
                Vista::encolaMensajeError("El campo nombre corto no es válido.");
            }
        }


        $curso = isset($datos['curso']) ? $datos['curso'] : null;

        if (empty($curso) || ! in_array($curso, array('Primero_ESO', 'Segundo_ESO', 'Tercero_ESO', 'Cuarto_ESO', 'Primero_BACH', 'Segundo_BACH'))) {
            Vista::encolaMensajeError('El campo CURSO no puede estar vacío.');
        } else {
            switch ($curso) {
                case 'Primero_ESO': $curso = 1; break;
                case 'Segundo_ESO':  $curso = 2; break;
                case 'Tercero_ESO':  $curso = 3; break;
                case 'Cuarto_ESO':  $curso = 4; break;
                case 'Primero_BACH':  $curso = 5; break;
                case 'Segundo_BACH':  $curso = 6; break;
            }
        }


        if(! Vista::hayMensajesError()){
            $asignatura = new Asignatura(
                null,
                $curso,
                $nombre_corto,
                $nombre_completo

            );

            $asignatura_id = $asignatura->dbInsertar();
        }

        
        if ($asignatura_id) {
            Vista::encolaMensajeExito('Asignatura creada correctamente.', "/admin/asignatura/$asignatura_id/ver/");
        } else {
            Vista::encolaMensajeError('Hubo un error al crear la asignatura.');
        }


     $this->genera($datos);

        
    }
}