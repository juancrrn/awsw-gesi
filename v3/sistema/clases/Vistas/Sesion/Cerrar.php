<?php 

/**
 * Vista de cierre de sesión.
 *
 * Cualquiera que haya iniciado la sesión: puede cerrarla.
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

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Vistas\Vista;

class Cerrar extends Modelo
{
	private const VISTA_NOMBRE = "Cerrar sesión";
	private const VISTA_ID = "sesion-cerrar";

	public function __construct()
	{
		$this->nombre = self::VISTA_NOMBRE;
		$this->id = self::VISTA_ID;
	}

	public function procesa() : void
	{

		Sesion::cierra();

		Vista::encolaMensajeExito('Se ha cerrado la sesión correctamente.', '');

	}
}

?>