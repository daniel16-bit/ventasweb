<?php 
include 'models/conexion.php';

$sql = "SELECT * FROM DEPARTAMENTO";
$result = $conexion->query($sql);

$departamentos = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $departamentos[] = $row;
    }
} else {
    echo "No se encontraron departamentos.";
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
    <title>Departamentos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
                        <div class="sb-sidenav-menu-heading">Navegacion</div>
                        <a class="nav-link" href="Dashboard.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Panel</a>
                        <div class="sb-sidenav  -menu-heading">Registros</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
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
                    </div>
                </div>
            </nav>
        </div>
                <div id="layoutSidenav_content">
                    <main>
                        <div id="layoutSidenav_content">
                                <div class="container-fluid px-4">
                                    <h1 class="mt-4">DEPARTAMENTOS </h1>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"data-bs-target="#miModal">Registrar Departamento nuevo </button>
                                    <a href="Reportes/Departamentospdf.php" class="btn btn-primary">Generar Reporte</a>
                            <!-- Modal -->
                            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="miModalLabel">
                                                <h2 class="text-center mb-4">REGISTRAR DEPARTAMENTO</h2>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Formulario de Registro de Departamento -->
                                            <form action="controllers/registrar_departamento.php" method="POST" class="was-validated">
                                                <div class="mb-3">
                                                    <label for="nombreDepartamento" class="form-label">Nombre del Departamento</label>
                                                    <input type="text" class="form-control" id="nombreDepartamento" name="nombreDepartamento" placeholder="Nombre Departamento" required>
                                                    <div class="invalid-feedback">Este campo es obligatorio</div>
                                                </div>
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
                                <div>Administrador</div> 
                            </div> 
                        </div>      
                <main>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table me-1"></i>Tabla Departamentos</div>
                              <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id Departamento</th>
                                            <th>Nombre Departamento</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($departamentos as $departamento): ?>
                                            <tr>
                                                <td><?php echo $departamento['ID_Departamento']; ?></td>
                                                <td><?php echo $departamento['Nombre']; ?></td>
                                                <td>
                                                    <a href="./modificar/modificar_departamento.php?id=<?php echo $departamento['ID_Departamento']; ?>">
                                                        <i class="fas fa-edit" style="font-size:30px; color: #d63384;"></i>
                                                    </a>
    
                                                    <!-- Enlace para eliminar el departamento -->
                                                    <a href="#" data-href="controllers/eliminar.php?id=<?php echo $departamento['ID_Departamento']; ?>"
                                                     data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                                     <i class='fas fa-trash-alt' style='font-size:30px; color:red'></i></a>
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
                    <a href="controllers/eliminar_departamentos.php?id=<?php echo $departamento['ID_Departamento']; ?>" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
$('#confirmar-delete').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var href = button.data('href'); // Extraer la URL de eliminación
    var modal = $(this);
    modal.find('#btn-eliminar').attr('href', href); // Actualizar el botón de eliminación
});
</script>
</body>
</html>