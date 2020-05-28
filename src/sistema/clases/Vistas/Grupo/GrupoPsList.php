<?php 

/**
 * Vista de gestión de usuarios.
 *
 * - PAS: único permitido.
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



namespace Awsw\Gesi\Vistas\Grupo;



use Awsw\Gesi\App;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Datos\Grupo;

use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsCreate as GrupoPsCreate;

use Awsw\Gesi\Sesion;


class GrupoPsList extends Modelo
{

        private const VISTA_NOMBRE = "Gestionar grupos";
        private const VISTA_ID = "grupo-ps-list";

        private $listado;

        public function __construct()
        {
            Sesion::requerirSesionPs();

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;

            $this->listado = Grupo::dbGetAll();
        }

        public function procesaContent() : void
        {
            $html = <<< HTML
            <h2 class="mb-4">$this->nombre</h2>
            HTML;

            $html .= $this->generarListaGrupos();

            echo $html;
        }

        /**
         * Genera el listado de grupos.
         * 
         * @return string Listado de grupos.
         */
        public function generarListaGrupos(): string
        {
            //Create grupo
            $formGrupoPsCreate = new GrupoPsCreate();
            $formGrupoPsCreateModal = $formGrupoPsCreate ->generateModal();



            $formGrupoPsCreateButton = $formGrupoPsCreate->generateButton('Crear',null,true);
            $html = <<< HTML
            <h3 class="mb-4">$formGrupoPsCreateButton Estudiantes</h3>
            <table id="grupo-lista" class="table table-borderless table-striped">
              
            
            </table>
            HTML;

            return $html;
        }
}
    















 ?>