<?php

    use App\Propiedad;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    require '../../includes/app.php';
    estaAutenticado();

    //Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: ../index.php');
    }

    //Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Asugnar los atributos
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        //Validacion
        $errores = $propiedad->validar();

        /** SUBIDA DE ARCHIVOS */

        //Generar nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //Setear la imagen
        //Realiza un resize a la imagen con intervention version 3.4
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $manager = new Image(Driver::class);
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
            $propiedad->setImagen($nombreImagen);
        }

        //Revisar que el array de errores este vacio
        if(empty($errores)){
            //Almacenar imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            
            $propiedad->guardar();
        }
    }
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="../index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            
            <?php include '../../includes/templates/formularioPropiedades.php'; ?>

            <input type="submit" value="Actualizar Propirdad" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>