<?php 

/**
 * Vistas de calendario.
 *
 * - PDI: puede editar todos los calendarios.
 * - PD: puede editar los calendarios de sus asignaturas.
 * - Estudiantes: pueden ver el calendario de sus asignaturas.
 * - Resto: pueden ver el calendario público.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Vistas\Evento;

use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class EventoInvList extends Modelo
{
    private const VISTA_NOMBRE = "Eventos públicos";
    private const VISTA_ID = "evento-lista";

    public function __construct()
    {
        Sesion::requerirSesionNoIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;
    }

    public function procesaContent(): void
    {
        $form = new EventoInvCreate();
        $formModal = $form->generateModal();
        $formButton = $form_>generateButton('Eventos programados');

        $html = <<< HTML
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