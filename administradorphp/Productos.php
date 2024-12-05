<?php 
include 'models/conexion.php';

$sql = "SELECT 
P.ID_Producto, 
P.Nombre AS Nombre_Producto, 
P.ValorProducto, 
P.ValorVenta, 
PR.Nombe AS Nombre_Proveedor, 
P.Stock, 
P.Existencia
FROM 
PRODUCTO P
JOIN 
PROVEEDOR PR ON P.ID_Proveedor = PR.ID_Proveedor";
$result = $conexion->query($sql);

$productos = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $productos[] = $row;
    }
} else {
    echo "No se encontraron ciudades.";
}
?>
<?php
session_start();
if(isset($_SESSION['Prime_Nombre']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Productos - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                <p class="text-light">Usted ingresó como:<?php echo $_SESSION['Prime_Nombre']; ?></p>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                        <li><a class="dropdown-item" href="#!">Historial de Actividades</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
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
                                Registros
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">                                 
                                    <a class="nav-link" href="Departamentos.php">Departamentos</a>
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
                             <!--  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>-->
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">PRODUCTOS</h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                            Registrar Nuevo Producto
                        </button>
    
                        <!-- Modal -->
                        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="miModalLabel">
                                            <h2 class="text-center mb-4">DATOS DEL PRODUCTO</h2>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="controllers/registro_producto.php" method="post">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                                            <label for="valor_producto" class="form-label">Valor del producto</label>
                                            <input type="text" class="form-control" name="valor_producto" placeholder="Valor del producto" required>
                                            <label for="valor_venta" class="form-label">Valor de venta</label>
                                            <input type="text" class="form-control" name="valor_venta" placeholder="Valor de venta" required>
                                            <label for="id_proveedor" class="form-label">Id Proveedor</label>
                                            <input type="text" class="form-control" name="id_proveedor" placeholder="Id Proveedor" required>
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="text" class="form-control" name="stock" placeholder="Stock" required>
                                            <label for="existencia" class="form-label">Existencia</label>
                                            <input type="text" class="form-control" name="existencia" placeholder="Existencia" required>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </form>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <a href="Productos.php" class="btn1">Registrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="sb-sidenav-footer">
                            <div class="small">Usted ingreso como:</div>
                            Administrador
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content">
                    <main>
                          <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Tabla Productos
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID_Producto</th>
                                                <th>Nombre</th>
                                                <th>ValorProducto</th>
                                                <th>ValorVenta</th>
                                                <th>ID_Proveedor</th>
                                                <th>Stock</th>
                                                <th>Existencia</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>   
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productos as $producto): ?>
                                               <tr>
                                                    <td><?php echo $producto['ID_Producto'];?></td>
                                                    <td><?php echo $producto['Nombre_Producto'];?></td>
                                                    <td><?php echo $producto['ValorProducto'];?></td>
                                                    <td><?php echo $producto['ValorVenta'];?></td>
                                                    <td><?php echo $producto['Nombre_Proveedor'];?></td>
                                                    <td><?php echo $producto['Stock'];?></td>
                                                    <td><?php echo $producto['Existencia'];?></td>
                                                    <td><a href="modificar_ciudad.php?id=<?php echo $producto['ID_Producto']; ?>">
                                                        <i class="fas fa-edit" style="font-size:30px; color: #d63384;"></i>
                                                      </a></td>
                                                    <td>
                                                      <a href="Productos.php?id=<?php echo $producto['ID_Producto']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete">
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
                    <a href="controllers/eliminar_producto.php?id=<?php echo $producto['ID_Producto']; ?>" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
    </body>
</html> 