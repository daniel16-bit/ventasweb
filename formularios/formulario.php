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
                <div class="password-container">
    <input type="password" class="form-user" id="password" placeholder="Contraseña" name="password" required>
    <i class="material-icons toggle-password">visibility</i>
</div>

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
    <script>
    // Comprobamos si hay datos almacenados en las cookies
    window.onload = function() {
        // Verificar si hay cookies almacenadas para el usuario y la contraseña
        if (document.cookie.indexOf("user") !== -1) {
            const userCookie = getCookie("user");
            const passwordCookie = getCookie("password");
            const rememberPasswordCheckbox = document.getElementById("inputRememberPassword");

            // Si las cookies existen, pre-cargar el formulario
            if (userCookie && passwordCookie) {
                document.getElementById("user").value = userCookie;
                document.getElementById("password").value = passwordCookie;
                rememberPasswordCheckbox.checked = true; // Marcar la casilla de recordar contraseña
            }
        }
    };

    // Función para obtener el valor de una cookie por su nombre
    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Al enviar el formulario, guardar las credenciales en las cookies si la opción está marcada
    document.getElementById("loginForm").onsubmit = function(event) {
        const rememberPasswordCheckbox = document.getElementById("inputRememberPassword");
        const user = document.getElementById("user").value;
        const password = document.getElementById("password").value;

        if (rememberPasswordCheckbox.checked) {
            // Guardamos las credenciales en cookies por 30 días
            setCookie("user", user, 30);
            setCookie("password", password, 30);
        } else {
            // Si no se marca la casilla, eliminar las cookies
            deleteCookie("user");
            deleteCookie("password");
        }
    };

    // Función para establecer una cookie
    function setCookie(name, value, days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        let expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Función para borrar una cookie
    function deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleIcon = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');

        toggleIcon.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
        });
    });
</script>

</body>
</html>
