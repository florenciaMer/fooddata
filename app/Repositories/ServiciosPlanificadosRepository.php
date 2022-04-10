<?php


namespace App\Repositories;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;

class ServiciosPlanificadosRepository
{
    function devolverFechaI($mes, $anio) {
        $fechai ='';

            $fechai = $anio .'-'. $mes."-01";
            $fechai = date ($fechai);
            return $fechai;
    }

    function devolverFechaF($mes, $anio) {
        $fechaf ='';
        if ($mes == 1) {
            $fechaf = $anio."-01-31";
        }
        if ($mes == 2) {
            $fechaf = $anio."-02-28";
        }
        if ($mes == 3) {
            $fechaf = $anio."-03-31";
        }
        if ($mes == 4) {
            $fechaf = $anio."-04-30";
        }
        if ($mes == 5) {
            $fechaf = $anio."-05-31";
        }
        if ($mes == 6) {
            $fechaf = $anio."-06-30";
        }
        if ($mes == 7) {
            $fechaf = $anio."-07-31";
        }
        if ($mes == 8) {
            $fechaf = $anio."-08-31";
        }
        if ($mes == 9) {
            $fechaf = $anio."-09-30";
        }
        if ($mes == 10) {
            $fechaf = $anio."-10-31";
        }
        if ($mes == 11) {
            $fechaf = $anio."-11-30";
        }
        if ($mes == 12) {
            $fechaf = $anio."-12-31";
        }
        $fechaf = date($fechaf);
        return $fechaf;
    }

    public function dayWeek($fecha) {

        $weekMap = [
            0 => 'domingo',
            1 => 'lunes',
            2 => 'martes',
            3 => 'miercoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sabado',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];

        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($fecha);
        $day = $fecha->formatLocalized('%A');
        switch ($day) {
            case 'Monday':
                $dia = 'Lunes';
            break;

            case 'Tuesday':
                $dia = 'Martes';
                break;

            case 'Wednesday':
                $dia = 'Miércoles';
                break;

            case 'Thursday':
                $dia = 'Jueves';
                break;

            case 'Friday':
                $dia = 'Viernes';
                break;

            case 'Saturday':
                $dia = 'Sábado';
                break;

            case 'Sunday':
                $dia = 'Domingo';
                break;

            default:
            'no es un dia de semana';
        }
        return $dia;
    }

    function devolverMes($fecha) {
        $fecha = Carbon::parse($fecha);

        if ($fecha->format('m') == 1) {
            $mes = 1;
        }
        if ($fecha->format('m') == 2) {
            $mes = 2;
        }
        if ($fecha->format('m') == 3) {
            $mes = 3;
        }
        if ($fecha->format('m') == 4) {
            $mes = 4;
        }
        if ($fecha->format('m') == 5) {
            $mes = 5;
        }
        if ($fecha->format('m') == 6) {
            $mes = 6;
        }
        if ($fecha->format('m') == 7) {
            $mes = 7;
        }
        if ($fecha->format('m') == 8) {
            $mes = 8;
        }
        if ($fecha->format('m') == 9) {
            $mes = 9;
        }
        if ($fecha->format('m') == 10) {
            $mes = 10;
        }
        if ($fecha->format('m') == 11) {
            $mes = 11;
        }
        if ($fecha->format('m') == 12) {
            $mes = 12;
        }

        return $mes;
    }

    function devolverAnio($fecha) {
        $fecha = Carbon::parse($fecha);

        if ($fecha->year == 2020) {
            $anio = 2020;
        }
        if ($fecha->year == 2021) {
            $anio = 2021;
        }
        if ($fecha->year == 2022) {
            $anio = 2022;
        }
        if ($fecha->year == 2023) {
            $anio = 2023;
        }
        if ($fecha->year == 2024) {
            $anio = 2024;
        }
        if ($fecha->year == 2025) {
            $anio = 2025;
        }
        return $anio;
    }
}
