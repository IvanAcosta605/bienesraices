<?php
    //Conectaese a la BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Autenticar el usuario
    $errores = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[]= "El E-Mail es Obligatorio";
        }
        if(!$password){
            $errores[]= "El Password es Obligatorio";
        }
        if(empty($errore)){
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($db, $query);
            if($resultado -> num_rows){
                $usuario = mysqli_fetch_assoc($resultado);
                //Revisar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    //El usuario esta autenticado
                    session_start();
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    header('Location: /bienesraices/admin/index.php');
                } else{
                    $errores[] = "El password es incorrecto";
                }
            } else{
                $errores[] = "El Usuario no existe";
            }
        }
    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form method="POST" class="formulario" novalidate>
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu E-mail" id="email">
                
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password">

                <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>