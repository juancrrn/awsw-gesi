<?php

namespace Awsw\Gesi\Validacion;

use Awsw\Gesi\App;
use Awsw\Gesi\Datos\Asignatura;
use Awsw\Gesi\Datos\Usuario;
use DateTime;
use JsonSerializable;

/**
 * Esta clase representa una franja (slot) de un horario de Gesi.
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

class GesiScheduleSlot implements JsonSerializable
{

    /**
     * @var string $asignaturaNombre
     * @var string $profesorNombre
     * @var string|null $foroUrl
     * @var string $dia
     * @var int $horaInicio
     * @var int $minutosInicio
     * @var int $horaFinal
     * @var int $minutosFinal
     */
    public $asignaturaNombre;
    public $profesorNombre;
    public $foroUrl;
    public $dia;
    public $horaInicio;
    public $minutosInicio;
    public $horaFinal;
    public $minutosFinal;
            
    public function __construct(
        string $asignaturaNombre,
        string $profesorNombre,
        $foroUrl,
        string $dia,
        int $horaInicio,
        int $minutosInicio,
        int $horaFinal,
        int $minutosFinal
    )
    {
        $this->asignaturaNombre = $asignaturaNombre;
        $this->profesorNombre = $profesorNombre;
        $this->foroUrl = $foroUrl;
        $this->dia = $dia;
        $this->horaInicio = $horaInicio;
        $this->minutosInicio = $minutosInicio;
        $this->horaFinal = $horaFinal;
        $this->minutosFinal = $minutosFinal;
    }

    public function getAsignaturaNombre(): string
    {
        return $this->asignaturaNombre;
    }

    public function getProfesorNombre(): string
    {
        return $this->profesorNombre;
    }

    public function getForoUrl()
    {
        return $this->foroUrl;
    }

    public function getDia(): string
    {
        return $this->dia;
    }

    public function getInicio(): string
    {
        $zeroFilledHora = ($this->horaInicio < 10 ? '0' : '') . $this->horaInicio;
        $zeroFilledMinutos = ($this->minutosInicio < 10 ? '0' : '') . $this->minutosInicio;
        return $zeroFilledHora . ':' . $zeroFilledMinutos;
    }

    public function getInicioEnMinutos(): int
    {
        return $this->horaInicio * 60 + $this->minutosInicio;
    }

    public function getFinal(): string
    {
        $zeroFilledHora = ($this->horaFinal < 10 ? '0' : '') . $this->horaFinal;
        $zeroFilledMinutos = ($this->minutosFinal < 10 ? '0' : '') . $this->minutosFinal;
        return $zeroFilledHora . ':' . $zeroFilledMinutos;
    }

    public function getFinalEnMinutos(): int
    {
        return $this->horaFinal * 60 + $this->minutosFinal;
    }

    public function getDuracionEnMinutos(): int
    {
        return $this->getFinalEnMinutos() - $this->getInicioEnMinutos();
    }

    /**
     * Valida un formato de horario Gesi.
     * 
     * @return bool
     */
    public static function validaGesiSchedule(string $schedule): bool
    {
        $app = App::getSingleton();

        $validDays = $app->getScheduleDayValid();
        
        $day = "([$validDays]{1})";
        $hora = '([0-9]{1,2})';
        $minutos = '([0-9]{2})';
        $slot = "$day $hora:$minutos $hora:$minutos;";

        preg_match_all("#$slot#", $schedule, $matches, PREG_OFFSET_CAPTURE);

        // Verificar que hay algún resultado.
        $nTotal = sizeof($matches[0]);

        if (! $nTotal > 0) return false;

        // Verificar que no hay partes no válidas.
        $lTotal = sizeof($matches[0]) - 1; // Espacios entre slots.

        for ($i = 0; $i < $nTotal; $i++) {
            $lTotal += strlen($matches[0][$i][0]);
        }

        if (strlen($schedule) != $lTotal) return false;

        // Validar horas.
        $horaInicio = $matches[2];
        $minutosInicio = $matches[3];
        $horaFinal = $matches[4];
        $minutosFinal = $matches[5];

        $inicioGlobalObj = DateTime::createFromFormat('H:i', $app->getScheduleTimeStartLimit());
        $finalGlobalObj = DateTime::createFromFormat('H:i', $app->getScheduleTimeEndLimit());

        for ($i = 0; $i < $nTotal; $i++) {
            $inicioActualObj = DateTime::createFromFormat('H:i', $horaInicio[$i][0] . ':' . $minutosInicio[$i][0]);
            $finalActualObj = DateTime::createFromFormat('H:i', $horaFinal[$i][0] . ':' . $minutosFinal[$i][0]);
            
            // Comprobar que las horas de inicio están en las franjas correctas y la primera no es posterior a la segunda.

            if (! (
                $inicioGlobalObj->diff($inicioActualObj)->invert == 0 &&
                $inicioActualObj->diff($finalActualObj)->invert == 0 &&
                $finalActualObj->diff($finalGlobalObj)->invert == 0
            )) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convierte un formato de horario Gesi a array de objetos de franjas.
     * 
     * @requires El formato se ha validado anteriormente.
     * 
     * @param string $asignaturaNombre
     * @param string $profesorNombre
     * @param string|null $foroUrl
     * 
     * @return array
     */
    public static function convierteGesiSchedule(string $schedule, string $asignaturaNombre, string $profesorNombre, $foroUrl = null): array
    {
        $day = '([LMXJVSD]{1})';
        $number = '([0-9]{1,2})';
        $slot = "$day $number:$number $number:$number;";

        preg_match_all("#$slot#", $schedule, $matches, PREG_OFFSET_CAPTURE);

        $result = array();

        $nTotal = sizeof($matches[0]);

        $dia = $matches[1];
        $horaInicio = $matches[2];
        $minutosInicio = $matches[3];
        $horaFinal = $matches[4];
        $minutosFinal = $matches[5];

        for ($i = 0; $i < $nTotal; $i++) {
            $slot = new GesiScheduleSlot(
                $asignaturaNombre,
                $profesorNombre,
                $foroUrl,
                $dia[$i][0],
                $horaInicio[$i][0],
                $minutosInicio[$i][0],
                $horaFinal[$i][0],
                $minutosFinal[$i][0]
            );

            $result[] = $slot;
        }

        return $result;
    }

    /**
     * Genera un color a partir del nombre de la asignatura del slot.
     * 
     * @return string
     */
    public function generateColor(): string
    {
        if (! $this->getAsignaturaNombre()) return null;

        // Color de base.
        $hMin = 295;
        $hMax = 305;
        $sMin = 30;
        $sMax = 60;
        $lMin = 40;
        $lMax = 70;

        // Convertir nombre a entero.
        $i = crc32($this->getAsignaturaNombre());

        // Calcular color.
        $h = $i % ($hMax - $hMin) + $hMin;
        $s = $i % ($sMax - $sMin) + $sMin;
        $l = $i % ($lMax - $lMin) + $lMin;

        return 'hsl(' . $h . ',' . $s . '%,' . $l . '%)';
    }

    /**
     * Genera una cadena JSON con los slots a partir de una lista de 
     * asignaciones.
     * 
     * @param array $asignaciones
     * @param string $baseUrlForo
     * 
     * @return string
     */
    public static function generaJson(array $asignaciones, string $baseUrlForo): string
    {
        $app = App::getSingleton();

        $jsonBuffer = array();

        if (! empty($asignaciones)) {
            foreach ($asignaciones as $asignacion) {
                $asignatura = Asignatura::dbGet($asignacion->getAsignatura());
                $profesor = Usuario::dbGet($asignacion->getProfesor());

                $jsonBuffer = array_merge(
                    $jsonBuffer,  
                    GesiScheduleSlot::convierteGesiSchedule(
                        $asignacion->getHorario(),
                        $asignatura->getNombreCorto(),
                        $profesor->getNombreCompleto(),
                        $baseUrlForo . $asignacion->getForoPrincipal() . '/'
                    )
                );
            }
        }

        $json = htmlspecialchars(json_encode($jsonBuffer));

        return $json;
    }

    /**
     * Genera un elemento HTML de horario que se autocarga al estar lista la 
     * página.
     * 
     * @param array $asignaciones
     * @param string $baseUrlForo
     * 
     * @return string
     */
    public static function generateAutoSchedule(array $asignaciones, string $baseUrlForo): string
    {
        $json = self::generaJson($asignaciones, $baseUrlForo);
        $autoSchedule = '<div class="gesi-schedule" data-autolaunch="true" data-json="' . $json . '"></div>';

        return $autoSchedule;
    }

    /**
     * Genera un botón HTML para abrir un modal con un horario.
     * 
     * @param string $modalId
     * 
     * @return string
     */
    public static function generateModalButton(string $modalId): string
    {
        $button = '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#' . $modalId . '">Ver horario</button>';

        return $button;
    }

    /**
     * Genera un modal con un horario.
     * 
     * @param string $modalId
     * @param array $asignaciones
     * @param string $baseUrlForo
     * 
     * @return string
     */
    public static function generateScheduleModal(string $modalId, array $asignaciones, string $baseUrlForo): string
    {
        $json = self::generaJson($asignaciones, $baseUrlForo);

        $modal = <<< HTML
        <div class="modal gesi-schedule-modal fade" id="$modalId" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver horario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="gesi-schedule" data-autolaunch="false" data-json="$json"></div>
                    </div>
                </div>
            </div>
        </div>
        HTML;

        return $modal;
    }

    public function jsonSerialize()
    {
        return [
            'asignaturaNombre' => $this->getAsignaturaNombre(),
            'profesorNombre' => $this->getProfesorNombre(),
            'foroUrl' => $this->getForoUrl(),
            'dia' => $this->getDia(),
            'inicio' => $this->getInicio(),
            'final' => $this->getFinal(),
            'nameColor' => $this->generateColor()
        ];
    }
}

?>