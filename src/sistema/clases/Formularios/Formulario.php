<?php

/**
 * Ofrece funcionalidad para la gestión de formularios HTML normales.
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

namespace Awsw\Gesi\Formularios;

use Awsw\Gesi\App;

abstract class Formulario
{

    /**
     * @var string $form_id Cadena utilizada como valor del atributo "id" de la 
     *                      etiqueta <form> asociada al formulario y como 
     *                      parámetro a comprobar para verificar que el usuario 
     *                      ha enviado el formulario.
     */
    private $form_id;

    /**
     * @var string $action  URL asociada al atributo "action" de la etiqueta 
     *                      <form> del fomrulario y que procesará el envío del 
     *                      formulario.
     */
    private $action;

    /**
     * @var string $html    Almacena el HTML para generar el formulario. Que el 
     *                      HTML no se imprima directamente y se pueda procesar 
     *                      el formulario al inicio del script de vista, nos 
     *                      permite adelantar eventos y, por ejemplo, usar el 
     *                      mecanismo de mensajes de \Awsw\Gesi\Vistas\Vista.
     */
    protected $html = '';

    /**
     * Crea un nuevo formulario.
     * 
     * @param string $form_id Cadena utilizada como valor del atributo "id" de 
     *                        la etiqueta <form> asociada al formulario y como 
     *                        parámetro a comprobar para verificar que el 
     *                        usuario ha enviado el formulario.
     *
     * @param array $opciones (Ver más arriba.)
     */
    public function __construct($form_id, $opciones = array())
    {
        $this->form_id = $form_id;
        
        if (isset($opciones['action'])) {
            $opciones['action'] = App::getSingleton()->getUrl() . $opciones['action'];

            $opcionesPorDefecto = array();
        } else {
            $opcionesPorDefecto = array(
                'action' => null
            );
        }
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action   = $opciones['action'];
        
        if ( !$this->action ) {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
  
    /**
     * Procesa el envío de un formulario.
     */
    public function gestiona()
    {   
        if ($this->enviado($_POST)) {
            $this->procesa($_POST);
        }  
    }
  
    /**
     * Verifica si el usuario ha enviado el formulario y para ello comprueba si 
     * existe el parámetro $form_id en $params.
     *
     * @param array $params Array que contiene los datos recibidos en el envío 
     *                      formulario.
     *
     * @return bool         Devuelve true si $form_id existe como clave en 
     *                      $params.
     */
    private function enviado(& $params)
    {
        return isset($params["action"]) && $params["action"] == $this->form_id;
    } 

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param array $datos_iniciales Datos iniciales para los campos del 
     *                               formulario (normalmente $_POST).
     * 
     * @return string                HTML asociado a los campos del formulario.
     */
    protected function generaCampos(array & $datos_iniciales = array()): string
    {
        return '';
    }

    /**
     * Procesa los datos del formulario.
     * 
     * Durante el procesamiento del formulario pueden producirse errores, que 
     * serán gestionados por el mecanismo de mensajes definido en 
     * \Awsw\Gesi\Vistas\Vista.
     * 
     * En tal caso, es la propia función la que vuelve a generar el formulario
     * con los datos iniciales.
     *
     * @param array $datos Datos enviado por el usuario (normalmente $_POST).
     */
    protected function procesa(array & $datos): void
    {
        return;
    }

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string? $datos Array con los valores por defecto de los campos 
     *                       del formulario.
     *
     * @return string        HTML asociado al formulario.
     */
    public function genera(array & $datos = array()): void
    {
        $campos = $this->generaCampos($datos);

        $this->html = <<< HTML
        <form method="post" action="$this->action" id="$this->form_id" class="default-form">
            <input type="hidden" name="action" value="$this->form_id" />
            $campos
        </form>
        HTML;
    }

    /**
     * Imprime el HTML del formulario.
     */
    public function imprime(): void
    {
        echo $this->html;
    }

    /**
     * Devuelve el HTML del formulario.
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}

?>