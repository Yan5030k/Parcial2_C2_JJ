<?php
require 'conexion.php';

// Los usuarios no registrados ven los datos ordenados por nombre
$sql = "SELECT * FROM productos ORDER BY nombre_equipo ASC";
$result = $conn->query($sql);

$productos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($productos);
$conn->close();
?>