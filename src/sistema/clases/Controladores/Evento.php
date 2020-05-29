<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con eventos.
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
 * @version 0.0.4
 */

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Vistas\Evento\EventoEstList;


use Awsw\Gesi\Vistas\Evento\EventoInvList;
use Awsw\Gesi\FormulariosAjax\Evento\EventoaSesCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoesRead;

use Awsw\Gesi\Vistas\Evento\EventoPdList;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdDelete;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPdRead;

use Awsw\Gesi\Vistas\Evento\EventoPsList;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsCreate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsDelete;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsUpdate;
use Awsw\Gesi\FormulariosAjax\Evento\EventoPsRead;
class Evento extends Controlador
{

    public static function controla() : void
    {


        /**
         * Invitado
         */
        
        parent::get('/inv/evento/', function () {
            Vista::dibuja(new EventoEstList());
        });
        
        // Create. PD
        parent::get('/pd/evento/create/', function () {
            (new EventoPdCreate(true))->manage();
        });
        parent::post('/pd/evento/create/', function () {
            (new EventoPdCreate(true))->manage();
        });
        
        // Read. PD
        parent::get('/pd/evento/read/', function () {
            (new EventoPdRead(true))->manage();
        });


         // Update. PD
         parent::get('/pd/evento/update/', function(){
            (new EventoPdUpdate(true))->manage();
        });
        parent::patch('/pd/evento/update/', function(){
            (new EventoPdUpdate(true))->manage();
        });

        // Delete.  PD
           parent::get('/pd/evento/delete/', function(){
            (new EventoPdDelete(true))->manage();
        });
        parent::delete('/pd/evento/delete/', function(){
            (new EventoPdDelete(true))->manage();
        });



          // Create. PS
          parent::get('/ps/evento/create/', function () {
            (new EventoPsCreate(true))->manage();
        });
        parent::post('/ps/evento/create/', function () {
            (new EventoPsCreate(true))->manage();
        });
        
        // Read. PS
        parent::get('/ps/evento/read/', function () {
            (new EventoPsRead(true))->manage();
        });


         // Update. PS
         parent::get('/pd/evento/update/', function(){
            (new EventoPdUpdate(true))->manage();
        });
        parent::patch('/ps/evento/update/', function(){
            (new EventoPsUpdate(true))->manage();
        });

        // Delete.  PS
           parent::get('/ps/evento/delete/', function(){
            (new EventoPsDelete(true))->manage();
        });
        parent::delete('/ps/evento/delete/', function(){
            (new EventoPsDelete(true))->manage();
        });





    }
}

?>