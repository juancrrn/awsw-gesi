<?php

/**
 * Métodos relacionados con los foros.
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

namespace Awsw\Gesi\Datos;

use \Awsw\Gesi\App;

class Foro
{
	// Identificador único del foro
	private $id;

	// Tema a tratar en el foro
	private $tema;

	// Identificador de la relación profesor-grupo-asignatura del foro. Si es NULL, el foro es público
	private $profesor_grupo_asignatura;

	/**
	 * Constructor.
	 */
	private function __construct($id, $tema, $profesor_grupo_asignatura){
		$this->id = $id;
		$this->tema = $tema;
		$this->profesor_grupo_asignatura = $profesor_grupo_asignatura;
	}

	public static function dbInsertar(MensajeForo $mensajeF) : int {
	
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			INSERT
			INTO 
				gesi_foros
				(	
					id,
					tema,
					profesor_grupo_asignatura
				)
			VALUES
				(?,?,?)
		");

		$id = $mensajeF->getId();
		$tema = $mensajeF->getTema();
		$profesor_grupo_asignatura = $mensajeF->getProfesor_grupo_asignatura();

		$sentencia->blind_param(
			"isi",
			$id,
			$tema,
			$profesor_grupo_asignatura
		);

		$sentencia->execute();

		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		return $id_insertado;		
 }

	/**
	 * Trae un foro de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un foro con el id especificado.
	 *
	 * @return Foro
	 */
	public static function dbGet(int $id) {

		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				tema,
				profesor_grupo_asignatura
			FROM
				gesiForos
			WHERE
				id = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_tema,
			$result_profesor_grupo_asignatura,
		);
		
		$foro = null;

		while($sentencia->fetch()) {
			$foro = new Foro(
				$result_id,
				$result_tema,
				$result_profesor_grupo_asignatura
			);
		}
		
		$sentencia->close();

		return $foro;
	}

	/**
	 * Trae todos los mensajes de un foro de la base de datos.
	 *
	 * @param int $this->id
	 *
	 * @requires Existe algun mensaje en el foro especificado.
	 *
	 * @return array<MensajeForo>
	 */
	public static function dbGetMessages(){
		
		$result = [];
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
			M.id,
			M.foro,
			M.padre,
			M.usuario,
			M.contenido
			FROM
				gesi_foros F, gesi_mensajes_foros M
			WHERE
				F.id = M.foro
		");
		
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$this->foro,			
		);
		
		//$foro = null;

		while($sentencia->fetch()) {
			$result[] = new MensajeForo(
			$fila[getId()],
			$fila[getForo()],
			$fila[getPadre()],
			$fila[getUsuario()],
			$fila[getContenido()]
			);
		}
		
		$sentencia->close();

		return $result;	
	}
	public static function dbActualizar() : bool{
	
		$bbdd = App::getSingleton()->bbddCon();
	
		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_eventos
			SET
				tema = ?,
				profesor_grupo_asignatura = ?
				FROM
				gesi_foros
			WHERE
				id = ?
		");
	
		$id= $this->getId();
		$tema = $this->getTema();
		$profesor_grupo_asignatura= $this->getProfesor_grupo_asignatura();
	
		$sentencia->blind_param(
			"isi", 
			$id,
			$tema,
			$profesor_grupo_asignatura
			);
	
		$resultado = $sentencia->execute();
	
		$sentencia->close();
	
		return $resultado;
	  }
}




