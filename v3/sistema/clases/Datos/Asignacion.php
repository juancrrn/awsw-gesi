<?php

/**
 * Métodos relacionados con la relación asignatura-profesor-grupo.
 * Para abreviar, esta relación se denomina "asignación".
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

use Awsw\Gesi\App;

class Asignacion
{
	// Identificador único de la relación.
	private $id;

	// Asignatura de la asignación.
	private $asignatura;

	// Grupo de la asignación.
	private $grupo;

	// Profesor de la asignación.
	private $profesor;

	// Horario en que el profesor imparte la asignatura al grupo.
	private $horario;

	// Foro de recursos de la asignatura para el grupo.
	private $foro_principal;

	/**
	 * Constructor.
	 */
	private function __construct($id, $asignatura, $grupo, $profesor, $horario, $foro_principal)
	{
		$this->id = $id;
		$this->asignatur = $asignatura;
		$this->grupo = $grupo;
		$this->profesor = $profesor;
		$this->hoario = $horario;
		$this->foro_principal = $foro_principal;
	}
	
	/**
	 * Getters.
	 */
	public function getId(){
		return $this->id;
	}

	public function getAsignatura(){
		return $this->asignatura;
	}

	public function getGrupo(){
		return $this->grupo;
	}

	public function getProfesor(){
		return $this->profesor;
	}

	public function getHorario(){
		return $this->horario;
	}

	public function getForo(){
		return $this->foro_principal;
	}

		/*
	 *
	 * 
	 * Funciones de acceso a la base de datos (patrón de acceso a datos).
	 * 
	 * 
	 */

	/*
	 *
	 * Operaciones INSERT.
	 *  
	 */
	
	/**
	 * Inserta una nueva Asignacion en la base de datos.
	 * 
	 * @param Asignacion $this Asignacion a insertar.
	 * 
	 * @requires Restricciones de la base de datos.
	 * 
	 * @return int Identificador de la Asignacion insertada.
	 */
	public function dbInsertar() : int
	{
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_asignacion
				(
					profesor,
					grupo,
					asignatura,
					horario,
					foro_principal,
				)
			VALUES
				(?, ?, ?, ?, ?)
		");

		$profesor = $this->getProfesor();
		$grupo = $this->getGrupo();
		$asignatura = $this->getAsignatura();
		$horario = $this->getHorario();
		$foro_principal = $this->getForo();
		
		$sentencia->bind_param(
			"iiiii", 
			$profesor,
			$grupo,
			$asignatura,
			$horario,
			$foro_principal
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		$this->id = $id_insertado;

		return $this->id;
	}

	/*
	 *
	 * Operaciones SELECT.
	 *  
	 */

	/**
	 * Trae una Asignacion de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe una Asignacion con el id especificado.
	 *
	 * @return Asignacion
	 */
	public static function dbGet(int $id) : Asignacion
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				profesor,
				grupo,
				asignatura,
				horario,
				foro_principal
			FROM
				gesi_asignacion
			WHERE
				id = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
		$sentencia->execute();

		$resultado = $sentencia->get_result()->fetch_object();

		$asignacion = new Asignacion(
			$resultado->id,
			$resultado->profesor,
			$resultado->grupo,
			$resultado->asignatura,
			$resultado->horario,
			$resultado->foro_principal
		);

		$sentencia->close();
		
		return $asignacion;
	}

	public static function dbGetAll(): array {

		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				profesor,
				grupo,
				asignatura,
				horario,
				foro_principal
			FROM
				gesi_asignacion
		");
	
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_profesor,
			$result_grupo,
			$result_asignatura,	
		    $result_horario,			
			$result_foro_principal
		);

		$asignaciones = array();
		while($sentencia->fetch()) {
			$asignaciones[] = new Asignacion(
				$result_id,
				$result_profesor,
				$result_grupo,
				$result_asignatura,	
				$result_horario,			
				$result_foro_principal
			);		
		}

		$sentencia->close();
		return $asignaciones;	
	}

	/*
	 *
	 * Operaciones UPDATE.
	 *  
	 */

	/**
	 * Actualiza la información de una Asignacion en la base de datos.
	 * 
	 * @param Asignacion $this la Asignacion cuya información se va a actualizar.
	 * 
	 * @return bool Resultado de la ejecución de la sentencia.
	 */
	public function dbActualizar() : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_asignacion
			SET
				profesor = ?,
				grupo = ?,
				asignatura = ?,
				horario = ?,
				foro_principal = ?,
			WHERE
				id = ?
		");

		$id = $this->getId();
		$profesor = $this->getProfesor();
		$grupo = $this->getGrupo();
		$asignatura = $this->getAsignatura();
		$horario = $this->getHorario();
		$foro_principal = $this->getForo();

		$sentencia->bind_param(
			"iiiiii", 
			$id,
			$profesor,
			$grupo,
			$asignatura,
			$horario,
			$foro_principal
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}
}

