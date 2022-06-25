<?php

/**
 * mesExtenso - Retorma o mês por extenso
 *
 * @param integer $mes 
 * @param bool $reduzido 
 * @return void
 */
function mesExtenso($mes, $reduzido = false) {
    $aExtenso = [
        1 => "Janeiro",
        2 => "Fevereiro",
        3 => "Março",
        4 => "Abril",
        5 => "Maio",
        6 => "Junho",
        7 => "Julho",
        8 => "Agosto",
        9 => "Setembro",
        10 => "Outubro",
        11 => "Novembro",
        12 => "Dezembro"
    ];

    if ($reduzido) {
        return substr($aExtenso[(int)$mes], 0, 3);
    } else {
        return $aExtenso[(int)$mes];
    }
}