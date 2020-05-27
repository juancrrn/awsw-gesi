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
use JsonSerializable;

class Asignacion
	implements JsonSerializable
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
	public function __construct(
		$id,
		$asignatura, 
		$grupo,
		$profesor,
		$horario,
		$foro_principal
	)
	{
		$this->id = $id;
		$this->asignatura = $asignatura;
		$this->grupo = $grupo;
		$this->profesor = $profesor;
		$this->horario = $horario;
		$this->foro_principal = $foro_principal;
	}

	public static function fromDbFetch(Object $o) : Asignacion
	{
		return new self(
			$o->id,
			$o->asignatura,
			$o->grupo,
			$o->profesor,
			$o->horario,
			$o->foro_principal
		);
	}
	
	/**
	 * Getters.
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getAsignatura()
	{
		return $this->asignatura;
	}

	public function getGrupo()
	{
		return $this->grupo;
	}

	public function getProfesor()
	{
		return $this->profesor;
	}

	public function getHorario()
	{
		return $this->horario;
	}

	public function getForoPrincipal()
	{
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
					foro_principal
				)
			VALUES
				(?, ?, ?, ?, ?)
		");

		$profesor = $this->getProfesor();
		$grupo = $this->getGrupo();
		$asignatura = $this->getAsignatura();
		$horario = $this->getHorario();
		$foro_principal = $this->getForoPrincipal();
		
		$sentencia->bind_param(
			"iiisi", 
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

	/** 
	 * Trae todas las asignaciones
	 * 
	 * @param int $id del
	 * 
	 * @return array<Asignacion>
	 */
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

	/** 
	 * Trae todas las asignaciones de un grupo.
	 * 
	 * @param int $id grupo
	 * 
	 * @return array<Asignacion>
	 */
	public static function dbGetByGrupo(int $grupo_id) : array
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
				grupo = ?
		");

		$sentencia->bind_param(
			"i",
			$grupo_id
		);
	
		$sentencia->execute();

		$r = $sentencia->get_result();

		$as = array();

		while ($a = $r->fetch_object()) {
			$as[] = self::fromDbFetch($a);
		}

		$sentencia->close();
		return $as;	
	}

	/**
	 * Trae las asignaturas que imparte un profesor
	 * 
	 * @param int $id del profesor
	 * 
	 * @return array<Asignatura>
	 */
	public static function dbGetByProfesor(int $profesor) : array
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				profesor,
				asignatura,
				grupo,
				horario,
				foro_principal
			FROM
				gesi_asignacion		
			WHERE
				profesor = ?	
		");

		$sentencia->bind_param(
			"i",
			$profesor
		);

		$sentencia->execute();

		$r = $sentencia->get_result();

		$as = array();

		while ($a = $r->fetch_object()) {
			$as[] = self::fromDbFetch($a);
		}

		$sentencia->close();

		return $as;	
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
				foro_principal = ?
			WHERE
				id = ?
		");

		$id = $this->getId();
		$profesor = $this->getProfesor();
		$grupo = $this->getGrupo();
		$asignatura = $this->getAsignatura();
		$horario = $this->getHorario();
		$foro_principal = $this->getForoPrincipal();

		$sentencia->bind_param(
			"iiiisi", 
			$profesor,
			$grupo,
			$asignatura,
			$horario,
			$foro_principal,
			$id
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}


	/**
	 * 
	 * Comprobar si hay asignacion con un grupo
	 */

	public static function gpAsigGp($id_grupo) : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT
				id
			FROM
				gesi_asignacion
			WHERE
				grupo = ?
			LIMIT 1
		
		");

		$sentencia->bind_param(
			"i",
			$id_grupo
			);

		$sentencia->execute();
		$sentencia->store_result();

		if ($sentencia->num_rows > 0) {
			$existe = true;
		} else {
			$existe = false;
		}

		$sentencia->close();

		return $existe;
	}

	/**
	 * 
	 * Trae las asignaciones de una Asignatura
	 */

	public static function dbGetByAsignatura($id_asignatura) : array
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT
				id,
				profesor,
				asignatura,
				grupo,
				horario,
				foro_principal
			FROM
				gesi_asignacion
			WHERE
				asignatura = ?		
		");

		$sentencia->bind_param(
			"i",
			$id_asignatura
			);

		$sentencia->execute();
			
		$r = $sentencia->get_result();

		$asignaciones = array();

		while ($a = $r->fetch_object()) {
			$asignaciones[] = self::fromDbFetch($a);
		}

		$sentencia->close();

		return $asignaciones;
	}

	/**
	 * 
	 * Eliminar
	 */


	public static function dbEliminar(int $id) : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			DELETE
			FROM
				gesi_asignacion
			WHERE
				id = ?
		");

		$sentencia->bind_param(
			"i",
			$id
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}

	/**
	 * Implementa la interfaz JsonSerializable
	 */
	public function jsonSerialize()
	{
		return [
			'id' => $this->getId(),
			'asignatura' => $this->getAsignatura(),
			'grupo' => $this->getGrupo(),
			'profesor' => $this->getProfesor(),
			'horario' => $this->getHorario(),
			'foro_principal' => $this->getForoPrincipal()
		];
	}
}


