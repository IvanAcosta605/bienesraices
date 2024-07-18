<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    $vendedor = new Vendedor;
    //Arreglo con mensaje de errores
    $errores = Vendedor::getErrores();
    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Crear una nueva instancia
        $vendedor = new Vendedor($_POST['vendedor']);

        //Validar que no haya campos vacios
        $errores = $vendedor->validar();

        //No hay errores
        if(empty($errores)){
            $vendedor->guardar();
        }
    }
    incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="../index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/bienesraices/admin/vendedores/crear.php">
            
        <?php include '../../includes/templates/formularioVendedores.php'; ?>

        <input type="submit" value="Reegistrar Vendedor" class="boton boton-verde">
    </form>
</main>
<?php
    incluirTemplate('footer');
?>