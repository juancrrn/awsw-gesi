<?php 

/**
 * Creación de un usuario.
 * 
 * - PAS: solo PAS puede acceder
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

namespace Awsw\Gesi\Vistas\Usuario;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;
use Awsw\Gesi\Formularios\Usuario\AdminCrear as Formulario;

class AdminCrear extends Modelo
{

    private const VISTA_NOMBRE = "Nuevo usuario";
    private const VISTA_ID = "usuario-crear";

    private $formulario;

    public function __construct()
    {
        Sesion::requerirSesionPs();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->formulario = new Formulario("/admin/usuarios/crear/");
        $this->formulario->gestiona();
    }

    public function procesaContent() : void
    {
        $form = $this->formulario->getHtml();

        $html = <<< HTML
        <header class="page-header">
            <h1>$this->nombre</h1>
        </header>
        
        <section class="page-content">
            $form
        </section>

        HTML;

        echo $html;
    }
}

?>