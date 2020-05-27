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

use Awsw\Gesi\FormulariosAjax\Grupo\GrupoAdminCreate as FormGrupoAdminCreate;

use Awsw\Gesi\Sesion;


class GrupoAdminList extends Modelo{

        private const VISTA_NOMBRE = "Gestionar grupos";
        private const VISTA_ID = "grupo-admin-lista";


        private $listado;

        public function __construct(){

            Sesion::requerirSesionPs();

            $this->nombre = self::VISTA_NOMBRE;
            $this->id = self::VISTA_ID;


            $this->listadoGp = Grupo::dbGetAll();

        }


        public function procesaContect() : void{

            $app = App::getSingleton();

            $html = <<< HTML
            <h2 class="mb-4"> $this->nombre</h2>
            HTML;
            $html .= $this->generarListaGp();

            echo $html;
        }


        //Generar lista de grupos

        public function generarListaGp(): string {
            //Formulario de creacion de Grupo

            $formGrupoAdminCreate = new FormGrupoAdminCreate();

            $formGrupoAdminCreateModal = $formGrupoAdminCreate->generateModal();
            $formGrupoAdminCreateButton = $formGrupoAdminCreate->generateButton();


            $listGpBuffer = '';


            $html = <<< HTML
            <h3 class="mb-4">$formGrupoAdminCreateButton Grupos </h3>
            $formGrupoAdminCreateModal
            HTML;

            return $html;
        }
}
    















 ?>