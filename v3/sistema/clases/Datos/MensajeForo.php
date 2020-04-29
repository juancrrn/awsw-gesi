<?php

/**
 * Métodos relacionados con los mensajes de foros.
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

class MensajeForo
{
	// Identificador único de un mensaje en el foro
	private $id;

	// Foro al que pertenece el mensaje
	private $foro;

	// Mensaje al que responde, NULL si es el original
	private $padre;

	//usuario que escribio el mensaje
	private $usuraio;

	//contenido del mensaje
	private $contenido;

	/**
	 * Constructor.
	 */
	private function __construct($id, $foro, $padre, $usuario, $contenido)
	{
		$this->id = $id;
		$this->foro = $foro;
		$this->padre = $padre;
		$this->usuraio = $usuario;
		$this->contenido = $contenido;
	}

	public static function dbInsertar(MensajeForo $mensajeF) : int {
		$bbdd = App::getSingleton()->bbddCon();

		$sentencia = $bbdd->prepare("
			INSERT
			INTO 
				gesi_mensajes_foros
				(	
					id,
					foro,
					padre,
					usuario,
					contenido
				)
			VALUES
				(?,?,?,?)
		");

		$foro = $mensajeF->getForo();
		$padre = $mensajeF->getPadre();
		$usuario = $mensajeF->getUsuario();
		$contenido = $mensajeF->getContenido();

		$sentencia->bind_param(
			"iiiis",
			$id,
			$foro,
			$padre,
			$usuario,
			$contenido
		);

		$sentencia->execute();

		$id_insertado = $bbdd->insert_id;

		$sentencia->close();

		return $id_insertado;
		
 }

 public function getId(){
	return $this->id;
}

public function getForo(){
	return $this->foro;
}

public function getPadre(){
	return $this->padre;
}

public function getUsuario(){
	return $this->usuario;
}

public function getContenido(){
	return $this->contenido;
}

 public static function numMensajes($idMensajeForoPadre=NULL)
 {
   $result = 0;
   $bbdd = App::getSingleton()->bbddCon();

   
   $query = "SELECT COUNT(*) FROM gesi_mensajes_foros M, gesi_usuarios U WHERE U.id = M.usuario";
   if($idMensajeForoPadre) {
	 $query = $query . ' AND M.padre = %s';
	 $query = sprintf($query, $idMensajeForoPadre);
   } else {
	 $query = $query . ' AND M.padre IS NULL';
   }

   $rs = $conn->query($query);
   if ($rs) {
	 $result = (int) $rs->fetch_row()[0];
	 $rs->free();
   }
   return $result;
 }

 public static function getAllMsg() {
	
	$bbdd = App::getSingleton()->bbddCon();

	$sentencia = $bbdd->prepare("
		SELECT 
		id,
		foro,
		padre,
		usuario,
		contenido
		FROM
		gesi_mensajes_foros
		
	");
	
	$sentencia->execute();
	$sentencia->store_result();

	$sentencia->bind_result(
		$result_id,
		$result_foro,
		$result_padre,
		$result_usuario,
		$result_contenido
	);
	
	//$mensajeF = null;

	while($sentencia->fetch()) {
		$mensajesForo[] = new MensajeForo(
			$result_id,
			$result_foro,
			$result_padre,
			$result_usuario,
			$result_contenido
		);
	}
	
	$sentencia->close();

	return $mensajesForo;
 }

 public static function dbActualizar() : bool{
	
	$bbdd = App::getSingleton()->bbddCon();

	$sentencia = $bbdd->prepare("
		UPDATE
			gesi_eventos
		SET
			foro = ?,
			padre = ?,
			usuario = ?,
			contenido = ?
			FROM
			gesi_mensajes_foros
		WHERE
			id = ?
	");

	$id= $this->getId();
	$foro= $this->getForo();
	$padre= $this->getPadre();
	$usuario= $this->getUsuario();
	$contenido= $this->getContenido();

	$sentencia->bind_param(
		"issiii", 
		$id,
		$foro,
		$padre,
		$usuario,
		$contenido
		);

	$resultado = $sentencia->execute();

	$sentencia->close();

	return $resultado;
  }
}