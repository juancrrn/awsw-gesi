<?php

/**
 * Gesión del formulario para eliminar un Usuario de la Base de Datos.
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

namespace Awsw\Gesi\Formularios\Usuario;

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Vistas\Vista;

class AdminEliminar extends Formulario
{   
    private $nombre;
    private $id;

    public function __construct(string $action, string $nombre, int $id) {
        parent::__construct('form-usuario-eliminar', array('action' => $action));
        $this->nombre = $nombre;
        $this->id = $id;
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {
        $this->html .= <<< HTML
<div class="form-group">
    <input type="checkbox" name="eliminar" id="eliminar" value="$this->id" required="required">
    <label for="eliminar">Eliminar al usuario $this->nombre y todos sus datos de Gesi.</label>
</div>
<div class="form-actions">
    <button type="submit" class="btn">Eliminar</button>
</div>

HTML;
    }
    

    protected function procesa(array & $datos) : void
    {
        $eliminar = isset($datos['eliminar']) ? $datos['eliminar'] : null;

        if (empty($eliminar) || $eliminar != $this->id) {
            Vista::encolaMensajeError('Debes marcar la casilla de verificación para eliminar el usuario.');
        }

        if (! Vista::hayMensajesError()) {
            $resultado = Usuario::dbEliminar($this->id);
            
            if (! $resultado) {
                Vista::encolaMensajeError("No se ha podido eliminar el Usuario correctamente.", "/admin/usuarios/");
            } else {
                Vista::encolaMensajeExito("Se ha eliminado el usuario correctamente.", "/admin/usuarios/");
            }
        }

        $this->genera();
    }
}

?>