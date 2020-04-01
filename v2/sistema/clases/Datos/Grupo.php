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

namespace Awsw\Gesi;

class Grupo
{
	private $id;				// Identificador único de grupo

	private $curso;				// Tipo 1-6 (desde 1ºESO hasta 2ºBach).

	private $nombre_corto;		// Tipo “B1A”.

	private $nombre_completo;	// Tipo “Primer curso de Bachillerato A”.

	private $tutor;				// Profesor responsable del grupo.
	
	/**
	 * Constructor.
	 */

	private function __construct($id, $curso, $nombre_corto, $nombre_completo, $tutor)
	{
		$this->id = $id;
		$this->curso =$curso; 
		$this->nombre_corto = $nombre_corto; 
		$this->nombre_completo = $nombre_completo; 
		$this->tutor = $tutor; 
	}

	/**
	 * Trae todos los estudiantes de un grupo.
	 *
	 * @param int $id
	 *
	 * @requires Existe un grupo con el id especificado.
	 *
	 * @return array<Usuario>
	 */
	public static function dbGetEstudiantes(int $id)
	{
		/*
		$array;
		if(dbExisteId($id))
		{
			dbGet();
		}
		return array();
		*/
	}

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
}