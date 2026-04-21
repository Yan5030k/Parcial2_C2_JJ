<?php
require 'conexion.php';
$res_m = $conn->query("SELECT * FROM smartphones ORDER BY modelo ASC");
$res_h = $conn->query("SELECT * FROM hogar_inteligente ORDER BY nombre_equipo ASC");

echo json_encode([
    'smartphones' => $res_m->fetch_all(MYSQLI_ASSOC),
    'hogar' => $res_h->fetch_all(MYSQLI_ASSOC)
]);
?>