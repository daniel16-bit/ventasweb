<?php
header("Content-type: application/xls");
header("Content-Disposition: attachement; filename = Excel.xls");
?>

<?php  
  include "../models/conexion.php";   
    $where ="";     
    if (!empty($_POST)) {
        $valor = $_POST['nom'];
        if (!empty($valor)) {
            $where = "WHERE nombre LIKE '%$valor%'";
        }
    }    
    $sql = " SELECT 
    Z.ID_Zona, 
    Z.NombreZona, 
    D.Nombre AS NombreDepartamento
FROM 
    ZONA Z
JOIN 
    DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento $where";
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
    <title>Zonas</title>
</head>
<body>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Zonas
        </div>  
        <div class="card-body">             
            <table id="datatablesSimple"  class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre zona</th>
                        <th>Nombre Departamento</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php  
                     if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {                          
                    ?>             
                            <tr>
                                <td><?php echo $row['ID_Zona']; ?></td>
                                <td><?php echo $row['NombreZona']; ?></td>
                                <td><?php echo $row['NombreDepartamento']; ?></td>
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