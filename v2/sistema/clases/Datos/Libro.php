<?php

/**
 * Métodos relacionados con los libros.
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

class Libro
{
	private $id;
	private $autor;
	private $titulo;
	private $asignatura;
	private $isbn;
	private $editorial;

	/**
	 * Constructor.
	 */
	private function __construct(
		$id,
		$autor,
		$titulo,
		$asignatura,
		$isbn,
		$editorial
	)
	{
		$this->id = $id;
		$this->autor = $autor;
		$this->titulo = $titulo;
		$this->asignatura = $asignatura;
		$this->$isbn = $isbn;
		$this->editorial = $editorial;		
	}

	/**
	 * Inserta un nuevo libro en la base de datos.
	 * 
	 * @param Libro $libro Libro a insertar.
	 * 
	 * @requires Restricciones de la base de datos.
	 * 
	 * @return int Identificador del libro insertado.
	 */
	public static function dbInsertar(Libro $libro) : int {
		
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_libros
				(
					autor,
					titulo,
					asignatura,
					isbn,
					editorial
				)
			VALUES
				(?, ?, ?, ?, ?, ?)
		");

		$autor = $usuario->getAutor();
		$titulo = $usuario->getTitulo();
		$asignatura = $usuario->getAsignatura();
		$isbn = $usuario->getIsbn();
		$editorial = $usuario->getEditorial();
		
		$sentencia->bind_param(
			"sssss", 
			$autor,
			$titulo,
			$asignatura,
			$isbn,
			$editorial
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		return $id_insertado;
	}

	/**
	 * Devuelve el numero de ejemplares que tiene un libro
	 *
	 * @param int $id
	 *
	 * @requires Existe un ejemplar del libro especificado.
	 *
	 * @return int $result
	 */

	public static function numMensajes($id)
	{
	  $result = 0;
	  $app = App::getSingleton();
	  $conn = $app->conexionBd();
	  $query = "SELECT COUNT(*) FROM gesi_libros L WHERE L.id = id";
	  return $result;
	}

	/**
	 * Trae un libro de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un libro con el id especificado.
	 *
	 * @return Libro
	 */
	public static function dbGet(int $id) : Libro
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				autor,
				titulo,
				asignatura,
				isbn,
				editorial
			FROM
				gesi_libros
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
			$result_autor,
			$result_titulo,
			$result_asignatura,
			$result_isbn,
			$result_editorial
		);
		
		$libro = null;

		while($sentencia->fetch()) {
			$libro = new Libro(
				$result_id,
				$result_autor,
				$result_titulo,
				$result_asignatura,
				$result_isbn,
				$result_editorial
			);
		}
		
		$sentencia->close();

		return $libro;
	}




	/**
	 * Trae todos los ejemplares de un libro de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un ejemplar del libro especificado.
	 *
	 * @return array<EjemplarLibro>
	 */
	public static function dbGetEjemplares(int $id)
	{






		return array();
	}

	public function getId(){
		return $this->id;
	}

	public function getAutor(){
		return $this->autor;
	}
	
	public function getTitulo(){
		return $this->titulo;
	}
	
	public function getAsignatura(){
		return $this->asignatura;
	}
	
	public function getIsbn(){
		return $this->isbn;
	}
	
	public function getEditorail(){
		return $this->editorial;
	}
}