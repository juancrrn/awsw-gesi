<?php

/**
 * Clase base para la gestión de formularios.
 *
 * Además de la gestión básica de los formularios.
 */

namespace Awsw\Gesi\Formularios;

use Awsw\Gesi\App;

abstract class Formulario
{

    /**
     * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
     * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     */
    private $form_id;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
     * envío del formulario.
     */
    private $action;

    /**
     * Almacena el HTML para generar el formulario.
     * 
     * Que el HTML no se imprima directamente y se pueda procesar el formulario
     * al inicio del script de vista, nos permite adelantar eventos y, por 
     * ejemplo, usar el mecanismo de mensajes de \Awsw\Gesi\Vistas\Vista.
     */
    protected $html = "";

    /**
     * Crea un nuevo formulario.
     * @param string $form_id    Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al
     *                          formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     *
     * @param array $opciones (ver más arriba).
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
     * Orquesta todo el proceso de gestión de un formulario.
     */
    public function gestiona()
    {   
        if (! $this->enviado($_POST)) {
            $this->genera();
        } else {
            $this->procesa($_POST);
        }  
    }
  
    /**
     * Verifica si el usuario ha enviado el formulario y para ello comprueba si 
     * existe el parámetro $form_id en $params.
     *
     * @param array<string> $params Array que contiene los datos recibidos en el envío formulario.
     *
     * @return boolean Devuelve true si $form_id existe como clave en $params.
     */
    private function enviado(& $params)
    {
        return isset($params["action"]) && $params["action"] == $this->form_id;
    } 

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param array<string> $datos_iniciales Datos iniciales para los campos del formulario (normalmente $_POST).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {
        return;
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
     * @param array<string> $datos Datos enviado por el usuario (normalmente $_POST).
     */
    protected function procesa(array & $datos) : void
    {
        return;
    }

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string[] $datos (opcional) Array con los valores por defecto de los campos del formulario.
     *
     * @return string HTML asociado al formulario.
     */
    protected function genera(array & $datos = array()) : void
    {

        $this->html .= <<< HTML
        <form method="post" action="$this->action" id="$this->form_id" class="default-form">
            <input type="hidden" name="action" value="$this->form_id" />

HTML;

        $this->generaCampos($datos);
        
        $this->html .= <<< HTML
        </form>

HTML;

    }

    /**
     * Imprime el HTML del formulario.
     */
    public function imprime() : void
    {
        echo $this->html;
    }

    /**
     * Devuelve el HTML del formulario.
     */
    public function getHtml() : string
    {
        return $this->html;
    }
}
