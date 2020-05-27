<?php

/**
 * Métodos relacionados con las asignaturas.
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
use Awsw\Gesi\Formularios\Valido;
use JsonSerializable;

class Asignatura
	implements JsonSerializable
{

	private $id;

	private $nivel;

	private $curso_escolar;

	private $nombre_corto;

	private $nombre_completo;

	/**
	 * Constructor.
	 */
	public function __construct(
		$id,
		$nivel,
		$curso_escolar,
		$nombre_corto,
		$nombre_completo
	)
	{
		$this->id = $id;
		$this->nivel = $nivel;
		$this->curso_escolar = $curso_escolar;
		$this->nombre_corto = $nombre_corto;
		$this->nombre_completo = $nombre_completo;
	}

	public static function fromDbFetch(Object $o) : Asignatura
	{
		return new self(
			$o->id,
			$o->nivel,
			$o->curso_escolar,
			$o->nombre_corto,
			$o->nombre_completo
		);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getNivel()
	{
		return Valido::rawToNivel($this->nivel);
	}

	public function getNivelRaw()
	{
		return $this->nivel;
	}

	public function getCursoEscolar()
	{
		return Valido::rawToCursoEscolar($this->curso_escolar);
	}

	public function getCursoEscolarRaw()
	{
		return $this->curso_escolar;
	}

	public function getNombreCorto()
	{
		return $this->nombre_corto;
	}

	public function getNombreCompleto()
	{
		return $this->nombre_completo;
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
	 * Insertar una nueva Asignatura en la base de datos
	 * 
	 * @param Asignatura $this
	 * 
	 * @return int
	 */
	public function dbInsertar() : int
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_asignaturas(
					id,
					nivel,
					curso_escolar,
					nombre_corto,
					nombre_completo
				)
			VALUES
				(?, ?, ?, ?, ?)	
		");

		$id = $this->getId();
		$nivel = $this->getNivelRaw();
		$curso_escolar = $this->getCursoEscolarRaw();
		$nombre_corto = $this->getNombreCorto();
		$nombre_completo = $this->getNombreCompleto();

		$sentencia->bind_param(
			"iiiss",
			$id,
			$nivel,
			$curso_escolar,
			$nombre_corto,
			$nombre_completo,
		);

		$sentencia->execute();

		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		return $id_insertado;
	}

	/*
	 *
	 * Operaciones SELECT.
	 *  
	 */

	/**
	 * Comprueba si una asignatura existe en la base de datos en base a su
	 * identificador.
	 *
	 * @param int
	 *
	 * @return bool
	 */
	public static function dbExisteId(int $id) : bool
	{		
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT
				id
			FROM
				gesi_asignaturas
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

		if ($sentencia->num_rows > 0) {
			$existe = true;
		} else {
			$existe = false;
		}

		$sentencia->close();

		return $existe;
	}

	/**
	 * Seleccionar todas las asignaturas de la base de datos.
	 * 
	 * @return array<Asignatura>
	 */
	public static function dbGetAll() : array
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nivel,
				curso_escolar,
				nombre_corto,
				nombre_completo
			FROM
				gesi_asignaturas			
		");
	
		$sentencia->execute();
		$resultado = $sentencia->get_result();

		$asignaturas = array();

		while ($a = $resultado->fetch_object()) {
			$asignaturas[] = Asignatura::fromDbFetch($a);
		}

		$sentencia->close();

		return $asignaturas;	
	}

	/**
	 * Trae las asignaturas de un curso escolar específico.
	 * 
	 * @param int $curso escolar
	 * 
	 * @return array<Asignatura>
	 */
	public static function dbGetByCursoEscolar(int $curso_escolar) : array
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nivel,
				curso_escolar,
				nombre_corto,
				nombre_completo
			FROM
				gesi_asignaturas		
			WHERE
				curso_escolar = ?	
		");

		$sentencia->bind_param(
			"i",
			$curso_escolar
		);

		$sentencia->execute();
		$resultado = $sentencia->get_result();

		$asignaturas = array();

		while ($a = $resultado->fetch_object()) {
			$asignaturas[] = Asignatura::fromDbFetch($a);
		}

		$sentencia->close();

		return $asignaturas;	
	}

	/** 
	 * Trae una asignatura de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe una asignatura con el id especificado.
	 *
	 * @return Asignatura
	 */
	public static function dbGet(int $id) : Asignatura
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nivel,
				curso_escolar,
				nombre_corto,
				nombre_completo
			FROM
				gesi_asignaturas
			WHERE
				id = ?
			LIMIT 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
		$sentencia->execute();

		$resultado = $sentencia->get_result();

		$asignatura = Asignatura::fromDbFetch($resultado->fetch_object());

		$sentencia->close();
		
		return $asignatura;
	}

	/*
	 *
	 * Operaciones UPDATE.
	 *  
	 */

	/**
	 * Actualiza la información de una asignatura en la base de datos.
	 * 
	 * @param asignatura la asignatura cuya información se va a actualizar.
	 * 
	 * @return bool Resultado de la ejecución de la sentencia.
	 */
	public function dbActualizar() : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_asignaturas
			SET
				nivel = ?,
				curso_escolar = ?,
				nombre_corto = ?,
				nombre_completo = ?
			WHERE
				id = ?
		");
		
		$id = $this->getId();
		$nivel = $this->getNivelRaw();
		$curso_escolar = $this->getCursoEscolarRaw();
		$nombre_corto = $this->getNombreCorto();
		$nombre_completo = $this->getNombreCompleto();

		$sentencia->bind_param(
			"iissi",
			$nivel,
			$curso_escolar,
			$nombre_corto,
			$nombre_completo,
			$id
		);

		$resultado = $sentencia->execute();
		
		$sentencia->close();

		return $resultado;
	}


	/*
	 *
	 * Operaciones DELETE.
	 *  
	 */



	public static function dbEliminar(int $id) : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			DELETE
			FROM
				gesi_asignaturas
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

	public function jsonSerialize()
	{
		return [
			'uniqueId' => $this->getId(),
			'selectName' => $this->getNombreCompleto(),
			'id' => $this->getId(),
			'nivel' => $this->getNivel(),
			'curso_escolar' => $this->getCursoEscolar(),
			'nombre_corto' => $this->getNombreCorto(),
			'nombre_completo' => $this->getNombreCompleto()
		];
	}
}

?>