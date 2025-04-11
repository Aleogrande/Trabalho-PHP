<?php
function buscarDestinoPorId($destinos, $id) {
    foreach ($destinos as $d) {
        if ($d['id'] == $id) return $d;
    }
    return null;
}
