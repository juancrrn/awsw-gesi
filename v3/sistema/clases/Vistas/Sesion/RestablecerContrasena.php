<?php 

/**
 * Vistas de restablecer contraseña.
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

use Awsw\Gesi\Vistas\Modelo;

class RestablecerContrasena extends Modelo
{
    private const VISTA_NOMBRE = "Restablecer contraseña";
    private const VISTA_ID = "sesion-restablecer-contrasena";

    public function __construct()
    {
        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent() : void
    {

        echo <<< HTML
        <header class="page-header">
            <h1>$this->nombre</h1>
        </header>
        
        <section class="page-content">
            Esta vista aún no está implementada.
        </section>
        
        HTML;

    }
}

?>