<?php

/**
 * Gesión del formulario de editar un  Grupo
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

namespace Awsw\Gesi\Formularios\Grupo;

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Grupo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Formularios\Valido;
use Awsw\Gesi\Vistas\Vista;

class AdminEditar extends Formulario{

	private $idGrupo;
	private $grupo;

    public function __construct(string $action, string $id, Grupo $grupo){
        parent::__construct('form-grupo-editar', array('action' => $action));
		$this->idGrupo = $id;
		$this->grupo = $grupo;
    }


    protected function generaCampos(Array & $datos_iniciales = array()) : void{
        
			$nivel = isset($datos_iniciales['nivel']) ?
            $datos_iniciales['nivel'] : $this->grupo->getNivelRaw();
            
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
            $datos_iniciales['curso_escolar'] : $this->grupo->getCursoEscolarRaw();
        
        $nombre_corto = isset($datos_iniciales['nombre_corto']) ?
            $datos_iniciales['nombre_corto'] : $this->grupo->getNombreCorto();

        $nombre_completo = isset($datos_iniciales['nombre_completo']) ?
            $datos_iniciales['nombre_completo'] : $this->grupo->getNombreCompleto();;

        $tutor = isset($datos_iniciales['tutor']) ?
			$datos_iniciales['tutor'] : $this->grupo->getTutor();
			
			        /*
         * Listar los usuarios con rol personal docente, que pueden ser tutores.
         */

        $profesores = Usuario::dbGetByRol(2);

        $tutor_options = '';

        foreach ($profesores as $p) {
            $id = $p->getId();
            $nombre = $p->getNombreCompleto();
            $selected = $id == $tutor ? ' selected="selected"' : '';

            $tutor_options .= <<< HTML
			<option value="$id" $selected>$nombre</option>
HTML;
        }
			


            
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
			<input class="form-control" type="text" name="nombre_corto" id="nombre_corto" value="$nombre_corto" placeholder="Nombre" required="required" />
			</div>

			<div class="form-group">
			<label for="nombre_completo">Nombre completo</label>
			<input class="form-control" type="text" name="nombre_completo" id="nombre_completo" value="$nombre_completo" placeholder="Nombre" required="required" />
			</div>

			<div class="form-group">
    		<label for="tutor">Tutor</label>
    		<select class="form-control" name="tutor" id="tutor" required="required">
        	<option value="" selected>Selecciona...</option>
        	$tutor_options
    		</select>
			</div>

			<div class="form-actions">
    			<button type="submit" class="btn">Editar</button>
			</div>

HTML;
        
    }

    protected function procesa(array & $datos): void{
		$nivel = $datos['nivel'] ?? null;
        $curso_escolar = $datos['curso_escolar'] ?? null;
        $nombre_corto = $datos['nombre_corto'] ?? null;
        $nombre_completo = $datos['nombre_completo'] ?? null;
        $tutor = $datos['tutor'] ?? null;

		if (empty($nivel) || ! Valido::testNivelRaw($nivel)) {
            Vista::encolaMensajeError('El campo nivel no es válido.');
        }

		if(empty($nombre_corto)){
			Vista::encolaMensajeError("El campo Nombre Corto no puede estar vacío.");
		} 
		 else {
            if (! Valido::testStdString($nombre_corto)) {
                Vista::encolaMensajeError('El campo Nombre Corto no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.');
            }
		}
		
		if (empty($curso_escolar)) {
            Vista::encolaMensajeError('El campo curso escolar no puede estar vacío.');
        } elseif (! Valido::testStdInt($curso_escolar)) {
            Vista::encolaMensajeError('El campo curso escolar no es válido.');
        }


		if(empty($nombre_completo)){
			Vista::encolaMensajeError("El campo Nombre Completo no puede estar vacío.");
		}
		 else {
            if (! Valido::testStdString($nombre_completo)) {
                Vista::encolaMensajeError('El campo Nombre Completo no es válido. Solo puede contener letras, espacios y guiones; y debe tener entre 3 y 128 caracteres.');
            }
        }

		
		if (empty($tutor) || ! Valido::testStdInt($tutor) || ! Usuario::dbExisteId($tutor)) {
            Vista::encolaMensajeError('El campo tutor no es válido.');
        }

        


        if(! Vista::hayMensajesError()){
        	$grupo = new Grupo(
				$this->idGrupo,
				$nivel,
        		$curso_escolar,
        		$nombre_corto,
        		$nombre_completo,
        		$tutor

			);
			
			$grupo_id = $grupo->dbActualizar();

			
		if ($grupo_id) {
			Vista::encolaMensajeExito('Grupo editado correctamente.', "/admin/grupos/");
		} else {
			Vista::encolaMensajeError('Hubo un error al editar el Grupo.');
		}
     }


       
		$this->genera($datos);

	}

	
}






