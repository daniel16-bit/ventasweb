<?php  
  include "../models/conexion.php";   
    $where ="";     
    if (!empty($_POST)) {
        $valor = $_POST['nom'];
        if (!empty($valor)) {
            $where = "WHERE nombre LIKE '%$valor%'";
        }
    }    
    $sql = "SELECT * FROM PEDIDO $where";
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
    <title>Pedido</title>
</head>
<body>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Pedidos
        </div>  
        <div class="card-body">             
            <table id="datatablesSimple"  class="table table-striped">
            <div class="container" >
                <a href="../../vendedor/Pedidos.php" class="btn btn-dark r" >Regresar</a>        
                <a href="GenerarExcel_zona.php" class="btn btn-success">Generar Excel</a>       
                <a href="" class="btn btn-warning botimpr" onclick="window.print()">Imprimir/Descargar PDF</a>                
            </div>   
                <thead>
                <tr>
                        <th>Numero de pedido</th>
                        <th>Cliente</th>
                        <th>Fecha del pedido</th>
                        <th>Producto</th>
                        <th>Valor total del pedido</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['ID_Pedido']; ?></td>
                                <td><?php echo $row['ID_Cliente']; ?></td>
                                <td><?php echo $row['Fecha']; ?></td>
                                <td><?php echo $row['ID_Producto']; ?></td>
                                <td><?php echo $row['Valor_Total']; ?></td>                                                            
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
                </table>
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
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" role="dialog" aria-labelledby="confirmar-delete-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>  
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este Departamento? 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para actualizar el enlace de eliminación en el modal
        $('#confirmar-delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var href = button.data('href'); // Extraer la URL de eliminación
            var modal = $(this);
            modal.find('#btn-eliminar').attr('href', href); // Actualizar el botón de eliminación
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>