<?php

namespace Awsw\Gesi\Validacion;

use Awsw\Gesi\App;
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
 * @version 0.0.4-beta.01
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
        return $this->horaInicio . ':' . $this->minutosInicio;
    }

    public function getInicioEnMinutos(): int
    {
        return $this->horaInicio * 60 + $this->minutosInicio;
    }

    public function getFinal(): string
    {
        return $this->horaFinal . ':' . $this->minutosFinal;
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

    public function jsonSerialize()
    {
        return [
            'asignaturaNombre' => $this->getAsignaturaNombre(),
            'profesorNombre' => $this->getProfesorNombre(),
            'foroUrl' => $this->getForoUrl(),
            'dia' => $this->getDia(),
            'inicio' => $this->getInicioEnMinutos(),
            'inicioHora' => $this->getInicio(),
            'final' => $this->getFinalEnMinutos(),
            'finalHora' => $this->getFinal()
        ];
    }
}

?>