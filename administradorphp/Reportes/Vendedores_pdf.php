<?php  
  include "../models/conexion.php";   
    $where ="";     
    if (!empty($_POST)) {
        $valor = $_POST['nom'];
        if (!empty($valor)) {
            $where = "WHERE nombre LIKE '%$valor%'";
        }
    }    
    $sql = "SELECT 
    VE.ID_Vendedor, 
    U.Prime_Nombre AS Nombre_Vendedor, 
    U.Segundo_Nombre AS Segundo_Nombre_Vendedor, 
    U.Prime_Apellido AS Apellido_Vendedor, 
    U.Segundo_Apellido AS Segundo_Apellido_Vendedor,
    Z.NombreZona AS Zona
FROM 
    VENDEDOR VE
JOIN 
    USUARIO U ON VE.ID_Usuario = U.ID_Usuario
JOIN 
    ZONA Z ON VE.ID_Zona = Z.ID_Zona;
$where";
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
    <title>Vendedores</title>
</head>
<body>
    <div class="imagen-imprimir">
    <img src="image.png" alt="" class="img-fluid" id="imagen-imprimir">
</div>

    <div class="card mb-4">
         
        <div class="card-body">             
            <table id="datatablesSimple"  class="table table-striped">
            <div class="container" >
                <a href="../Vendedores.php" class="btn btn-dark r" >Regresar</a>        
                <a href="GenerarExcel_vendedores.php" class="btn btn-success">Generar Excel</a>       
                <a href="" class="btn btn-warning botimpr" onclick="window.print()">Imprimir/Descargar PDF</a>                
            </div>
            <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Vendedores 
        </div>    
                <thead>
                    <tr>
                        <th>ID_Vendedor</th>
                        <th>Nombre_Vendedor</th>
                        <th>Zona</th>
                   
                    </tr>
                </thead>
                <tbody>                
                    <?php  
                     if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {                          
                    ?>             
                            <tr>
                                <td><?php echo $row['ID_Vendedor']; ?></td>
                                <td><?php echo $row['Nombre_Vendedor']; ?></td>
                                <td><?php echo $row['Zona'] ?></td>                               
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