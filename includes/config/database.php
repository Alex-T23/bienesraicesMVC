<?php

function conectarDB() : mysqli {
    $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'] ?? '', $_ENV['DB_DB']);


    if(!$db){
        echo "Error en la conexión";
        exit;
    }

    return $db;
}