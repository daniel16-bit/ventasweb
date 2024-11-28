<?php
include_once '../Models/conexion.php';
// Get user input from the form
$user = $_POST['user'];
$password = $_POST['password'];

// Prepare SQL query to check if the user exists
$sql = "SELECT * FROM USUARIO WHERE Correo = ? AND Contraseña = ?";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $password); // "ss" means two string parameters

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // User exists, check their role
    $user_data = $result->fetch_assoc();
    $user_id = $user_data['ID_Usuario'];

    // Now check the user's role (ADMINISTRADOR or VENDEDOR)
    $role_sql = "SELECT * FROM rol WHERE ID_Usuario = ?";
    $role_stmt = $conn->prepare($role_sql);
    $role_stmt->bind_param("i", $user_id);
    $role_stmt->execute();
    $role_result = $role_stmt->get_result();

    if ($role_result->num_rows > 0) {
        $role_data = $role_result->fetch_assoc();
        if ($role_data['NombreRol'] == 'ADMINISTRADOR') {
            // Redirect to the admin dashboard
            header("Location: ../administradorphp/Dashboard.php");
        } else if ($role_data['NombreRol'] == 'VENDEDOR') {
            // Redirect to the seller dashboard
            header("Location: ../vendedor/VendedorDashboard.html");
        }
    } else {
        // No role found
        header("Location: ../index_1.php?error=Invalid role");
    }
} else {
    // User not found
    header("Location: ../index_1.php?error=Invalid username or password");
}

$stmt->close();
$conn->close();
?>
?>