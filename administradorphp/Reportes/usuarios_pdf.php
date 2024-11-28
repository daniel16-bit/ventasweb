<?php  
  include "../models/conexion.php";   
    $where ="";     
    if (!empty($_POST)) {
        $valor = $_POST['nom'];
        if (!empty($valor)) {
            $where = "WHERE nombre LIKE '%$valor%'";
        }
    }    
    $sql = "SELECT * FROM USUARIO $where";
    $resultado = $conexion->query($sql);
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de que jQuery esté incluido -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/styles.css" media="print">
    <title>Usuarios</title>
</head>
<body>
    <div class="imagen-imprimir">
    <img src="image.png" alt="" class="img-fluid" id="imagen-imprimir">
</div>

    <div class="card mb-4">
         
        <div class="card-body">             
            <table id="datatablesSimple"  class="table table-striped">
            <div class="container" >
                <a href="../Usuarios.php" class="btn btn-dark r" >Regresar</a>        
                <a href="GenerarExcel_usuarios.php" class="btn btn-success">Generar Excel</a>       
                <a href="" class="btn btn-warning botimpr" onclick="window.print()">Imprimir/Descargar PDF</a>                
            </div>
            <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Departamentos 
        </div>    
                <thead>
                    <tr>
                        <th>ID_Usuario</th>
                        <th>Prime_Nombre</th>
                        <th>Segundo_Nombre</th>
                        <th>Prime_Apellido</th>
                        <th>Segundo_Apellido</th>
                        <th>Telefono</th>
                        <th>Contraseña</th>
                        <th>correo</th>                   
                    </tr>
                </thead>
                <tbody>                
                    <?php  
                     if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {                          
                    ?>             
                            <tr>
                                <td><?php echo $row['ID_Usuario']; ?></td>
                                <td><?php echo $row['Prime_Nombre']; ?></td>
                                <td><?php echo $row['Segundo_Nombre']; ?></td>
                                <td><?php echo $row['Prime_Apellido']; ?></td>
                                <td><?php echo $row['Segundo_Apellido']; ?></td>
                                <td><?php echo $row['Telefono']; ?></td>
                                <td><?php echo $row['Contraseña']; ?></td>
                                <td><?php echo $row['Correo']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
                    
        </div>
    </div>
    </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
            </div>
        </div>
    </footer>
    </div>
    </div>
</body>
</html>