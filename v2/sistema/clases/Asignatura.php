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

namespace Awsw\Gesi;

class Asignatura
{


	private $id;

	private $curso;

	private $nombre_corto;

	private $nombre_largo;

	/**
	 * Constructor.
	 */
	private __construct(
		$id,
		$curso,
		$nombre_corto,
		$nombre_largo
		)
		{
		    $this->id = $id;
			$this->curso = $curso
			$this->nombre_corto = $nombre_corto;
			$this->nombre_largo = $nombre_largo;
		}


	/**
	 * 	Insertar una nueva Asignatura en la base de datos
	 * 
	 * @param Asignatura
	 * 
	 * @return int
	 */

	public static function dbInsertar(Asignatura $asignatura) int{
			$bbdd = App::getSingleton()->bbddCon();

			$sentencia = $bbdd->prepare("
				INSERT
				INTO 
					gesi_asignaturas
					(
						id,
						curso,
						nombre_corto,
						nombre_largo
					)
				VALUES
					(?,?,?,?)
			");

			$id = $asignatura->getId();
			$curso = $asignatura->getCurso();
			$nombre_corto = $asignatura->getNombreCorto();
			$nombre_largo = $asignatura->getNombreLargo();

			$sentencia->blind_param(
				"iiss",
				$id,
				$curso,
				$nombre_corto,
				$nombre_largo;
			);

			$sentencia->execute();

			$id_insertado = $bbdd->insert_id;

			$sentencia->close();

			return $id_insertado;
			
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

	 public static function dbGet(int $id) : Usuario
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
			id,
			curso,
			nombre_corto,
			nombre_largo
			FROM
				gesi_asignatura
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
			$result_curso,
			$result_nombre_corto,
			$result_nombre_largo
			
		);
		
		$usuario = null;

		while($sentencia->fetch()) {
			$asignatura = new Asignatura(
				$result_id,
				$result_curso,
				$result_nombre_corto,
				$result_nombre_largo

			);
		}
		
		$sentencia->close();

		return $usuario;
	}




}	


	/**
	 * Comprueba si una asignatura existe en la base de datos en base a su
	 * identificador.
	 *
	 * @param int
	 *
	 * @return bool
	 */

	public static function  dbExisteId(int $id) : bool
	{		
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT
				id
			FROM
				gesi_asignatura
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
	 * Actualiza la información de una asignatura en la base de datos.
	 * 
	 * @param asignatura la asignatura cuya información se va a actualizar.
	 * 
	 * @return bool Resultado de la ejecución de la sentencia.
	 */
	public static function dbActualizar(Asignatura $asignatura) : bool
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			UPDATE
				gesi_asignatura
			SET
				curso = ?,
				nombre_corto = ?,
				nombre_largo = ?,
			WHERE
				id = ?
		");

		$id = $asignatura->getId();
		$curso = $asignatura->getCurso();
		$nombre_corto = $asignatura->getNombreCorto();
		$nombre_largo = $asignatura->getNombreLargo();

		$sentencia->bind_param(
			"iss", 
			$curso,
			$nombre_corto,
			$nombre_largo,
			$id
		);

		$resultado = $sentencia->execute();

		$sentencia->close();

		return $resultado;
	}



	public function getId(){
		return $this->id;
	}

	public function getCurso(){
		return $this->curso;
	}

	public function getNombreCorto(){
		return $this->nombre_corto;
	}

	public function getNombreLargo(){
		return $this->nombre_largo;
	}