<?php 

/**
 * Vistas de mensajes de Secretaría.
 *
 * - PAS: pueden gestionar los mensajes.
 * - PD y estudiantes: pueden ver los mensajese enviados y enviar uno nuevo.
 * - Resto: pueden enviar mensajes.
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

namespace Awsw\Gesi\Vistas\MensajeSecretaria;

use Awsw\Gesi\Sesion;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Formularios\MensajeSecretaria\CreacionConSesion as Formulario;

class MiCrear extends Modelo
{

    private const VISTA_NOMBRE = "Nuevo mensaje de Secretaría";
    private const VISTA_ID = "mensaje-secretaria-crear";
    
    private $formulario;

    public function __construct()
    {
        Sesion::requerirSesionIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
        
        $this->formulario = new Formulario('/mi/secretaria/crear/');
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