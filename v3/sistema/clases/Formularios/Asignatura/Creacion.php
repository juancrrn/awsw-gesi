<?php

/**
 * Gesión del formulario de creación de asignatura.
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

namespace Awsw\Gesi\Formularios\Usuario;

use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\Asignatura;

class Creacion extends Formulario{
    public function __construct()
    {
        parent::__construct('formRegistro');
    }


protected function generaCamposFormulario($datos){
    $nombreAsignatura = '';
    $nombreAsignaturaCorto = '';


  $html = <<<EOF
    <fieldset>
        <div class="grupo-control">
            <label>Nombre de Asignatura: </label> <input class="control" type="text" name="nombreAsignatura" value="$nombreAsignatura"/>
        </div>

        <div class="grupo-control">
            <label>Nombre de Asignatura Corto: </label> <input class="control" type="text" name="nombreAsignaturaCorto" value="$nombreAsignaturaCorto"/>
        </div>

        <div class="grupo-control">
                
        <label>Primero de ESO:</label> <input class="control" type="radio" name="curso" value="PrimeroESO"  required/>
        <label>Segundo de ESO:</label> <input class="control" type="radio" name="curso" value="SegundoESO" required />
        <label>Tercero de ESO:</label> <input class="control" type="radio" name="curso" value="TerceroESO" required />
        <label>Cuarto de ESO:</label> <input class="control" type="radio" name="curso" value="CuartoESO" required />
        <label>Primero de Bachillerato:</label> <input class="control" type="radio" name="curso" value="PrimeroBACH" required />
        <label>Segundo de Bachillerato:</label> <input class="control" type="radio" name="curso" value="SegundoBACH" required />
        </div>

    </fieldset>
    EOF;
    return $html;


}


protected function procesaFormulario($datos){

    $result = array();

    $nombreAsignatura = isset($datos['nombreAsignatura']) ? $datos['nombreAsignatura']: null;
    $nombreAsignaturaCorto = isset($datos['nombreAsignaturaCorto']) ? $datos['nombreAsignaturaCorto']: null;
    if(empty($nombreAsignatura) ){
        $resutl[] = "El nombre completo de la Asignatura no puede estar vacío";
    }



    else if(empty($nombreAsignaturaCorto) ){
        $resutl[] = "El nombre corto de la Asignatura no puede estar vacío";
    }

    else if(mb_strlen($nombreAsignatura) <= mb_strlen($nombreAsignaturaCorto)){
        $result[] = "El nombre de la asignatura completo debe ser mas largo que el nombre corto de la asignatura.";
    }

    else{
        $curso = isset($datos['curso']);
        $asig = Asignatura::crea($nombreAsignatura, $nombreAsignaturaCorto, $curso);

        if(! $asig){
            $result[] ="La asignatura ya existe";
        }
        else{
            $result = 'index.php';
        }
    }
    return $result;

}
}


