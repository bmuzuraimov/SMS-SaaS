<?php
ini_set('display_error', 1); //включить отчет об ошибках
error_reporting(E_ALL); //вывод всех ошибок

function debug($str)
{
    echo "<pre>";
    var_dump($str);
    echo "</pre>";
    exit;
}
