<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    //Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: ../index.php');
    }

    //Obtener el arreglo del Vendedor
    $vendedor = Vendedor::find($id);

    //Arreglo con mensaje de errores
    $errores = Vendedor::getErrores();

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Asugnar los atributos
        $args = $_POST['vendedor'];

        //Sincronizar objeto en memoria
        $vendedor->sincronizar($args);

        //Validacion
        $errores = $vendedor->validar();

        //Revisar que el array de errores este vacio
        if(empty($errores)){
            $vendedor->guardar();
        }
    }
    incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>

    <a href="../index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
            
        <?php include '../../includes/templates/formularioVendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>
<?php
    incluirTemplate('footer');
?>