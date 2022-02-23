<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'juans','', 'bienes_raices');

    if(!$db) {
        echo "Error, no se puedo conectar";
        exit;
    }

    return $db;
}