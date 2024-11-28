<?php
include "../models/conexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreDepartamento = $_POST['nombreDepartamento'];

    if (!empty($nombreDepartamento)) {
        $sql = "INSERT INTO DEPARTAMENTO (Nombre) VALUES (?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("s", $nombreDepartamento);

        if ($stmt->execute()) {

            header("Location:../Departamentos.php");
            exit();
        } else {
            echo "Error al registrar el departamento: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "El nombre del departamento es obligatorio.";
    }

    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>

