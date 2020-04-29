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
	public static function dbGetEstudiantes(int $id): array{
	
		$result = [];
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				nif,
				rol,
				nombre,
				apellidos,
				fecha_nacimiento,
				numero_telefono,
				email,
				fecha_ultimo_acceso,
				fecha_registro,
				grupo
			FROM
				gesi_grupos G, gesi_usuarios E
			WHERE
				E.grupo = G.curso && E.roll = 1
		");
		$sentencia->bind_param(
			"i",
			$id
		);
		
		$sentencia->execute();
		$sentencia->store_result();

		$sentencia->bind_result(
			$result_id,
			$result_nif,
			$result_rol,
			$result_nombre,	
		    $result_apellidos,			
			$result_fecha_nacimiento,
			$result_numero_telefono,			
			$result_email,
			$result_fecha_ultimo_acceso,			
			$result_fecha_registro,
			$result_grupo			
		);
		
		$estudiantes = array();

		while($sentencia->fetch()) {
			$estudiantes[] = new Usuario(
				$result_id,
				$result_nif,
				$result_rol,
				$result_nombre,	
				$result_apellidos,
				$result_fecha_nacimiento,
				$result_numero_telefono,			
				$result_email,
				$result_fecha_ultimo_acceso,			
				$result_fecha_registro,
				$result_grupo);		
		}
		
		$sentencia->close();
		return $estudiantes;		
	}


	public static function dbInsertar(Grupo $grupo) : int {
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
		
		INSERT
		INTO
			gesi_grupos(
				id,
				curso_escolar,
				nombre_corto,
				nombre_completo,
				tutor
			)
		VALUES
		(?,?,?,?,?)	
		");


		$id = $grupo->getId();
		$curso_escolar = $grupo->getCurso();
		$nombre_corto = $grupo->getNombre_Corto();
		$nombre_completo = $grupo->getNombre_Completo();
		$tutor = $grupo->getTutor();

		$sentencia->bind_param(
			"iisss",
			$id,
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


	public function getId(){
		return $this->id;
	}

    public function getCurso(){
		return $this->curso;
	}
	public function getNombre_Corto(){
		return $this->nombre_corto;
	}

	public function getNombre_Completo(){
		return $this->nombre_completo;
	}

	public function getTutor(){
		return $this->tutor;
	}
}

		