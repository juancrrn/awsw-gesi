<?php 

/**
 * Métodos relacionados con los usuarios.
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

use Awsw\Gesi\App;
use JsonSerializable;

class Profesor 
    implements JsonSerializable{

    private $id;
    private $nif;
    private $rol;
    private $nombre;
    private $apellidos;
    private $fecha_nacimiento;
    private $numero_telefono;
    private $email;
    private $fecha_ultimo_acceso;
    private $fecha_registro;
    private $grupo;
}

 ?>