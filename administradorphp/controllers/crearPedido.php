<?php 
include '../models/conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<body>
<form action="controllers/ContPed.php" method="POST" enctype="multipart/form-data">   
<!-- Modal -->
<div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">
                                        <h2 class="text-center mb-4">REGISTRAR PEDIDO</h2>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                 </div>
                                <div class="modal-body">
                                        <input type="number" class="form-control" id="email" placeholder="Numero de Pedido" name="id" required>
                                        <br>
                                        <input type="text" class="form-control" id="email" placeholder="Cliente" name="cli" required>  
                                        <br>                                          
                                        <input type="date" class="form-control" id="email" placeholder="Fecha" name="fecha" required>
                                        <br>                                          
                                        <input type="text" class="form-control" id="email" placeholder="Producto" name="pro" required>     
                                        <br>                                         
                                        <input type="text" class="form-control" id="email" placeholder="Valor Total del Pedido" name="val" required>                                        
                                </div>
                                <button type="submit" class="btn btn-primary" name="registrar">Registrar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <?php
                                //include "controllers/mostrarPedidos.php"
                                ?>
                    </div>
                    </div>
                </div>
            </div>            
        </div>        
    </form>
</body>
</html>
