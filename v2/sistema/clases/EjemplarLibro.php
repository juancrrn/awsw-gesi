<?php

/**
 * Métodos relacionados con los ejemplares de libros.
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

class EjemplarLibro
{
	// Identificador del ejemplar.
	private $id;

	// Identificador del libro del que es copia.
	private $libro_id;

	// Número del ejemplar.
	private $numero;

	// Si está prestado, identificador del usuario que lo tiene. Si no, NULL.
	private $prestado;

	// Si está reservado, identificador del usuario que lo ha reservado.
	// Si no, NULL. Un libro puede estar reservado estando, a la vez, pedido.
	private $reservado;

	private $fecha_alta_prestamo;
	private $fecha_expiracion_prestamo;
	private $fecha_alta_reserva;
	
	/**
	 * Constructor.
	 */
	private function __construct(
		$id,
		$libro_id,
		$numero,
		$prestado,
		$fecha_alta_prestamo,
		$fecha_expiracion_prestamo,
		$fecha_alta_reserva
	)
	{
		$this->id = $id;
		$this->libro_id = $libro_id;
		$this->numero = $numero;
		$this->prestado = $prestado; //inicialmente a false
		$this->$fecha_alta_prestamo = $fecha_alta_prestamo; //inicialmente a null
		$this->fecha_expiracion_prestamo = $fecha_expiracion_prestamo; //inicialmente a null
		$this->fecha_alta_reserva = $fecha_alta_reserva; //inicialmente a null
	}

/**
	 * Inserta un ejemplar usuario en la base de datos.
	 * 
	 * @param EjemplarLibro $ejemplar Usuario a insertar.
	 * 
	 * @requires Restricciones de la base de datos.
	 * 
	 * @return int Identificador del ejemplar insertado.
	 */
	public static function dbInsertar(EjemplarLibro $ejemplar) : int {
		
		$bbdd = App::getSingleton()->bbddCon();
		
		$sentencia = $bbdd->prepare("
			INSERT
			INTO
				gesi_ejemplares
				(
					libro_id,
					numero,
					prestado,
					fecha_alta_prestamo,
					fecha_expiracion_prestamo,
					fecha_alta_reserva
				)
			VALUES
				(?, ?, ?, ?, ?, ?, ?)
		");

		$libro_id = $usuario->getLibroId();
		$numero = $usuario->getNumero();
		$prestado = $usuario->getPrestado();
		$fecha_alta_prestamo = $usuario->getFecha_alta_prestamo();
		$fecha_expiracion_prestamo = $usuario->getFecha_expiracion_prestamo();
		$fecha_alta_reserva = $usuario->getFecha_alta_reserva();

		$sentencia->bind_param(
			"s,i,b,s,s,s", 
			$libro_id,
			$numero,
			$prestado,
			$fecha_alta_prestamo,
			$fecha_expiracion_prestamo,
			$fecha_alta_reserva
		);

		$sentencia->execute();
		
		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		return $id_insertado;
	}


/**
	 * Trae un ejemplar de la base de datos.
	 *
	 * @param int $id
	 *
	 * @requires Existe un ejempalr con el id especificado.
	 *
	 * @return Ejemplar
	 */
	public static function dbGet(int $id) : Ejemplar
	{
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			SELECT 
				id,
				libro_id,
				numero,
				prestado,
				fecha_alta_prestamo,
				fecha_expiracion_prestamo,
				fecha_alta_reserva
			FROM
				gesi_ejemplares
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
			$result_libro_id,
			$result_numero,
			$result_prestado,
			$result_fecha_alta_prestamo,
			$result_fecha_expiracion_prestamo,
			$result_fecha_alta_reserva
		);
		
		$ejemplar = null;

		while($sentencia->fetch()) {
			$ejemplar = new Ejemplar(
			$result_id,
			$result_libro_id,
			$result_numero,
			$result_prestado,
			$result_fecha_alta_prestamo,
			$result_fecha_expiracion_prestamo,
			$result_fecha_alta_reserva
			);
		}
		
		$sentencia->close();

		return $libro;
	}
	
	public function getId(){
		
		return $this->id;
	}

	public function getLibro_id(){
		
		return $this->libro_id;
	}
	
	public function getNumero(){
		
		return $this->numero;
	}
	
	public function getPrestado(){
		
		return $this->prestado;
	}
	
	public function getFecha_alta_prestamo(){
		
		return $this->fecha_alta_prestamo;
	}
	
	public function getFecha_expiracion_prestamo(){
		
		return $this->fecha_expiracion_prestamo;
	}

	public function getFecha_alta_reserva(){
		
		return $this->fecha_alta_reserva;
	}
}