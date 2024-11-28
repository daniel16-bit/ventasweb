<?php 
include 'models/conexion.php';

$sql =  "SELECT 
V.ID_Venta,
V.Fecha,
V.Descuentos,
V.Total,
C.Nombre AS Nombre_Cliente,
U.Prime_Nombre AS Nombre_Vendedor,
U.Prime_Apellido AS Apellido_Vendedor,
Z.NombreZona AS Nombre_Zona,
D.Nombre AS Nombre_Departamento,
P.Nombre AS Nombre_Producto
FROM 
VENTA V
INNER JOIN CLIENTE C ON V.ID_Cliente = C.ID_Cliente
INNER JOIN VENDEDOR VE ON V.ID_Vendedor = VE.ID_Vendedor
INNER JOIN USUARIO U ON VE.ID_Usuario = U.ID_Usuario
INNER JOIN ZONA Z ON V.ID_Zona = Z.ID_Zona
INNER JOIN DEPARTAMENTO D ON V.ID_Departamento = D.ID_Departamento
INNER JOIN PRODUCTO P ON V.ID_Producto = P.ID_Producto;
";
$result = $conexion->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
$ventas = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $ventas[] = $row;
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
        <title>Ventas - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="Dashboard.php">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                        <li><a class="dropdown-item" href="#!">Regidtro de actividaes</a></li>
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
                                Panel</a>
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
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
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
                        <h1 class="mt-4">VENTAS </h1>                        
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                            Registrar Nueva venta
                        </button>
                        <a href="Reportes/ventas_pdf.php" class="btn btn-primary">Generar Reporte</a>
                        <!-- Modal -->
                        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="miModalLabel">
                                            <h2 class="text-center mb-4">DATOS VENTA</h2>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <label for="nombre" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="email" placeholder="Fecha"
                                                required>
                                            <label for="nombre" class="form-label">Descuentos</label>
                                            <input type="price" class="form-control" id="email" placeholder="Descuentos"
                                                required>
    
                                            <label for="nombre" class="form-label">Total</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Total" required>
                                                
                                                <label for="nombre" class="form-label">Id Cliente</label>
                                                <input type="text" class="form-control" id="email"
                                                    placeholder="Id Cliente" required>
                                                    <label for="nombre" class="form-label">Id vendedor</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Id vendedor" required>
                                                <label for="nombre" class="form-label">Id zona</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Id zona" required>

                                        </form><label for="nombre" class="form-label">Id Departamento</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Id Departamento" required>
                                                <label for="nombre" class="form-label">Id Producto</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Id Producto" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <a href="..//Ventas.html" class="btn1">Registrar</a>
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
                                    Tabla Ventas
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Descuentos</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>Zona</th>
                                        <th>Departamento</th>
                                        <th>Producto</th>
                                        <th>Acciones</th>
                                    </tr>

                                        </thead>
                                        <tbody>
                                        <?php foreach ($ventas as $venta): ?>
                                            <tr>
                                                <td><?php echo $venta['ID_Venta']; ?></td>
                                                <td><?php echo $venta['Fecha']; ?></td>
                                                <td><?php echo $venta['Descuentos']; ?></td>
                                                <td><?php echo $venta['Total']; ?></td>
                                                <td><?php echo $venta['Nombre_Vendedor'] . " " . $venta['Apellido_Vendedor']; ?></td>
                                                <td><?php echo $venta['Nombre_Zona']; ?></td>
                                                <td><?php echo $venta['Nombre_Departamento']; ?></td>
                                                <td><?php echo $venta['Nombre_Producto']; ?></td>
                                                <td><a href="modificar_venta.php?id=<?php echo $venta['ID_Venta']; ?>">
                                                      <i class="fas fa-edit" style="font-size:22px; color: #d63384;"></i>
                                                     </a>
                                                     <a href="Ventas.php?id=<?php echo $venta['ID_Venta']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete">
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
                            ¿Estás seguro de que deseas eliminar esta venta?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="controllers/eliminar_venta.php?id=<?php echo $venta['ID_Venta']; ?>" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
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
