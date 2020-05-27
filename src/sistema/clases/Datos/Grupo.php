<?php

/**
 * Métodos relacionados con los grupos.
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

class Grupo
	implements JsonSerializable
{
	
	// Identificador único de grupo
	private $id;

	// Tipo 1 - 6 (desde ESO 1 hasta Bach. 2)
	private $nivel;

	// Tipo 2019 (para el curso 2019 - 2020)
	private $curso_escolar;

	// Tipo “B1A”
	private $nombre_corto;

	// Tipo “Primer curso de Bachillerato A”
	private $nombre_completo;

	// Profesor responsable del grupo
	private $tutor;
	
	/**
	 * Constructor.
	 */

	public function __construct(
		$id,
		$nivel,
		$curso_escolar,
		$nombre_corto,
		$nombre_completo,
		$tutor
	)
	{
		$this->id = $id;
		$this->nivel = $nivel;
		$this->curso_escolar = $curso_escolar; 
		$this->nombre_corto = $nombre_corto; 
		$this->nombre_completo = $nombre_completo; 
		$this->tutor = $tutor; 
	}

	public static function fromDbFetch(Object $o) : Grupo
	{
		return new self(
			$o->id,
			$o->nivel,
			$o->curso_escolar,
			$o->nombre_corto,
			$o->nombre_completo,
			$o->tutor
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

	public function getTutor()
	{
		return $this->tutor;
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
	 * Inserta un grupo en la base de datos
	 * 
	 * @param Grupo $this Grupo a insertar
	 * 
	 * @return int Identificador del grupo insertado
	 */
	public function dbInsertar() : int
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_grupos(
					id,
					nivel,
					curso_escolar,
					nombre_corto,
					nombre_completo,
					tutor
				)
			VALUES
				(?, ?, ?, ?, ?, ?)	
		");

		$id = $this->getId();
		$nivel = $this->getNivelRaw();
		$curso_escolar = $this->getCursoEscolarRaw();
		$nombre_corto = $this->getNombreCorto();
		$nombre_completo = $this->getNombreCompleto();
		$tutor = $this->getTutor();

		$sentencia->bind_param(
			"iiisss",
			$id,
			$nivel,
			$curso_escolar,
			$nombre_corto,
			$nombre_completo,
			$tutor
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
	 * Trae un grupo de la base de datos
	 * 
	 * @param int $id Identificador del grupo a seleccionar
	 * 
	 * @return Grupo Grupo seleccionado
	 */
	public static function dbGet(int $id) : Grupo{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nivel,
				curso_escolar,
				nombre_corto,
				nombre_completo,
				tutor
			FROM
				gesi_grupos
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

		$grupo = self::fromDbFetch($resultado->fetch_object());

		$sentencia->close();

		return $grupo;		
	}

	/**
	 * Trae todos los grupos de la base de datos.
	 *
	 * @return array<Grupo>
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
			nombre_completo,
			tutor
		FROM
			gesi_grupos
			
		");
	
		$sentencia->execute();
		$resultado = $sentencia->get_result();

		$grupos = array();

		while ($g = $resultado->fetch_object()) {
			$grupos[] = self::fromDbFetch($g);
		}

		$sentencia->close();

		return $grupos;	
	}

	/**
	 * Trae todos los grupos de la base de datos.
	 *
	 * @return array<Grupo>
	 */
	public static function dbGetGruposId($id) : array
	{

		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
			id,
			nivel,
			curso_escolar,
			nombre_corto,
			nombre_completo,
			tutor
		FROM
			gesi_grupos
		WHERE
			id = ?
		");

		$sentencia->bind_param(
			"i",
			$id
		);
	
		$sentencia->execute();
		$resultado = $sentencia->get_result();

		$grupos = array();

		while ($g = $resultado->fetch_object()) {
			$grupos[] = self::fromDbFetch($g);
		}

		$sentencia->close();

		return $grupos;	
	}

	/**
	 * Comprueba si un grupo existe en la base de datos en base a su
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
				gesi_grupos
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
	 * Comprueba si algun grupo tiene como turo al profesor con
	 * identificador id.
	 *
	 * @param int
	 *
	 * @return bool
	 */
	public static function dbAnyByTutor(int $id) : bool
	{		
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT
				id
			FROM
				gesi_grupos
			WHERE
				tutor = ?
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

	/*
	 *
	 * Operaciones UPDATE.
	 *  
	 */

	public function dbActualizar() : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_grupos
			SET
				id = ?,
				nivel = ?,
				curso_escolar = ?,
				nombre_corto = ?,
				nombre_completo = ?,
				tutor = ?
				WHERE
				id = ?
		");

		$id = $this->getId();
		$nivel = $this->getNivelRaw();
		$curso_escolar = $this->getCursoEscolar();
		$nombre_corto = $this->getNombreCorto();
		$nombre_completo = $this->getNombreCompleto();
		$tutor= $this->getTutor();
		

		$sentencia->bind_param(
			"iiisssi",
			$id,
			$nivel,
			$curso_escolar,
			$nombre_corto,
			$nombre_completo,
			$tutor,
			$id
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}


	/**
	 * Eliminar un grupo
	 */
	public static function dbEliminar(int $id) : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			DELETE
			FROM
				gesi_grupos
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
	 * Implementa la interfaz JsonSerializable.
	 */
	public function jsonSerialize()
	{
		return [
			'uniqueId' => $this->getId(),
			'selectName' => $this->getNombreCompleto(),
			'id' => $this->getId(),
			'nivel' => $this->getNivel(),
			'cursoEscolar' => $this->getCursoEscolar(),
			'nombreCorto' => $this->getNombreCorto(),
			'nombreCompleto' => $this->getNombreCompleto(),
			'tutor' => $this->getTutor()
		];
	}
}

?>