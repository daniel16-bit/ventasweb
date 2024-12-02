<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="fondo">
    <div class="login-container">
        <form class="login-form" id="loginForm" action="../administradorphp/controllers/validar_login.php"  method="POST" >
            <div class="volver">
                <i class="material-icons">arrow_back</i><a href="../index.php">Volver inicio</a>
            </div>
            <div class="form_input"> 
                <h1>Bienvenido a COLFAR</h1>
                 
                <?php
                 if(isset($_GET['error'])){?>
                   <p class="text-danger"><?php echo $_GET['error'];?></p>
                 <?php  
                 }
                ?> 

                <label for="user">Usuario:</label>
                <input type="text" class="form-user" id="user" placeholder="Nombre de Usuario" name="user" required>
            </div>
            <div class="form_input">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-user" id="password" placeholder="Contraseña"   name="password" required>
            </div>
            <div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                <label class="form-check-label" for="inputRememberPassword">Recordar contraseña</label>
            </div>
            <div class="text-center"><a class="small" href="form.olvido.pass.html">¿Has olvidado tu contraseña?</a></div>
            <div class="text-center"><a class="small" href="form.crea_cuenta.html">¡Crea una cuenta!</a></div>
        </form>
    </div>
</body>
</html>
