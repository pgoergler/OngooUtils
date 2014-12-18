<?php

function decimal($number)
{
    return round($number, 2, PHP_ROUND_HALF_UP);
}

function ceilling($number, $significance = 1)
{
    return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number / $significance) * $significance) : false;
}

function flooring($number, $significance = 1)
{
    return ( is_numeric($number) && is_numeric($significance) ) ? (floor($number / $significance) * $significance) : false;
}
