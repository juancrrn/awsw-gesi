<?php

/**
 * Representa un modelo para las vistas.
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

namespace Awsw\Gesi\Vistas;

abstract class Modelo
{
	protected $nombre;
	protected $id;

	/**
	 * Se llama a esta función antes de procesar la cabecera. En su caso, puede 
	 * servir para comprobar permisos, mostrar mensajes, etc.
	 */
	public function procesaAntesDeLaCabecera() : void
	{
	}

	/**
	 * Procesa la lógica de la vista en el elemento <article>, que deberá 
	 * imprimir HTML y realizar lo que sea conveniente.
	 */
	abstract public function procesaContent() : void;

	/**
	 * Procesa la lógica de la vista en el elemento <aside>, que deberá 
	 * imprimir HTML y realizar lo que sea conveniente.
	 */
	public function procesaSide() : void
	{
	}

	public function getNombre() : string
	{
		return $this->nombre;
	}

	public function getId() : string
	{
		return $this->id;
	}
}

?>