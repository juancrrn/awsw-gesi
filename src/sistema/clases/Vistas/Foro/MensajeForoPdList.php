<?php 

/**
 * Vistas de foros.
 *
 * - PDI: puede ver y gestionar todos los foros.
 * - Resto: pueden ver los foros a los que tienen acceso.
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

namespace Awsw\Gesi\Vistas\Foro;

use Awsw\Gesi\Vistas\Modelo;

class MiLista extends Modelo
{
    private const VISTA_NOMBRE = "Foros";
    private const VISTA_ID = "foro-lista";

    private $listado;

    public function __construct()
    {
        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->listado = array(); // TODO: recuperar el listado de eventos (calendario)
    }

    public function procesaContent(): void
    {
        // var_dump($this->listado);
        
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