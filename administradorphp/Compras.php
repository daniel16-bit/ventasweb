<?php 
include 'models/conexion.php';

$sql = "SELECT 
    c.ID_Compra,
    c.Fecha,
    c.Cantidad,
    p.Nombre AS Nombre_Producto,
    u.Prime_Nombre AS Nombre_Vendedor,  
    u.Prime_Apellido AS Apellido_Vendedor, 
    v.Fecha AS Fecha_Venta,
    v.Descuentos,
    v.Total
FROM 
    COMPRA c
JOIN 
    PRODUCTO p ON c.ID_Producto = p.ID_Producto
JOIN 
    VENTA v ON c.ID_Compra = v.ID_Venta
JOIN 
    VENDEDOR vd ON v.ID_Vendedor = vd.ID_Vendedor
JOIN 
    USUARIO u ON vd.ID_Usuario = u.ID_Usuario;
";
$result = $conexion->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
$compras = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $compras[] = $row;
    }
} else {
    echo "No se encontraron compras.";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Compras - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                        <li><a class="dropdown-item" href="#!">Historial de Actividades</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../index_1.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Navegación</div>
                            <a class="nav-link" href="Dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Panel
                            </a>
                            <div class="sb-sidenav-menu-heading">Registros</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Registros <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">                                 
                                    <a class="nav-link" href="layout-static.html">Departamentos</a>
                                    <a class="nav-link" href="Ciudades.php">Ciudades</a>
                                    <a class="nav-link" href="Zonas.php">Zonas</a>
                                    <a class="nav-link" href="Clientes.php">Clientes</a>
                                    <a class="nav-link" href="Vendedores.php">Vendedores</a>
                                    <a class="nav-link" href="Compras.php">Compras</a>
                                    <a class="nav-link" href="Ventas.php">Ventas</a>
                                    <a class="nav-link" href="Usuarios.php">Usuarios</a>
                                    <a class="nav-link" href="Productos.php">Productos</a>
                                    <a class="nav-link" href="Proveedores.php">proveedores</a>    
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Compras</h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">Registrar Nueva Compra</button>
                        <a href="Reportes/compras_pdf.php" class="btn btn-primary">Generar Reporte</a>
                        <!-- Modal -->
                        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="miModalLabel"><h2 class="text-center mb-4">Datos de la Compra</h2></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="controllers/registrar_compras.php" method="POST">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="fecha" name="fecha" required>

                                            <label for="cantidad" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>

                                            <label for="id_producto" class="form-label">Id Producto</label>
                                            <input type="number" class="form-control" id="id_producto" name="id_producto" required>

                                            <label for="id_proveedor" class="form-label">Id Proveedor</label>
                                            <input type="number" class="form-control" id="id_proveedor" name="id_proveedor" required>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sb-sidenav-footer">
                        <div>Usted ingresó como:</div>
                        <div>Administrador</div>
                    </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabla de Compras
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID_Compra</th>
                                            <th>Fecha</th>
                                            <th>Cantidad</th>
                                            <th>Nombre Producto</th>
                                            <th>Nombre Vendedor</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($compras as $compra): ?>
                                        <tr>
                                            <td><?php echo $compra['ID_Compra']; ?></td>
                                            <td><?php echo $compra['Fecha']; ?></td>
                                            <td><?php echo $compra['Cantidad']; ?></td>
                                            <td><?php echo $compra['Nombre_Producto']; ?></td>
                                            <td><?php echo $compra['Nombre_Vendedor'] . ''. $compra['Apellido_Vendedor']; ?></td>
                                                
                                              <td><a href="modificar_compra.php?id=<?php echo $compra['ID_Compra']; ?>">
                                                      <i class="fas fa-edit" style="font-size:30px; color: #d63384;"></i>
                                                  </a>
                                                  <a href="Compras.php?id=<?php echo $compra['ID_Compra']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                                    <i class="fas fa-trash-alt" style="font-size:30px; color:rgb(255, 70, 70)" ></i>
                                                  </a>
                                              </td>
                                        </tr>
                                    <?php endforeach; ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
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
                    ¿Estás seguro de que deseas eliminar este cliente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="controllers/eliminar_compra.php?id=<?php echo $compra['ID_Compra']; ?>" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>

        <!-- Script para actualizar el enlace del botón de confirmación de eliminación -->
        <script>
        // Script para actualizar el enlace de eliminación en el modal
        $('#confirmar-delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var href = button.data('href'); // Extraer la URL de eliminación
            var modal = $(this);
            modal.find('#btn-eliminar').attr('href', href); // Actualizar el botón de eliminación
        });
    </script>
</body>
</html>
