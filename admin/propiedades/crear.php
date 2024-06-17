<?php
    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    estaAutenticado();

    //Base de datos//
    $db = conectarDB();

    $propiedad = new Propiedad;

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        /**Crea una nueva instancia */
        $propiedad = new Propiedad($_POST['propiedad']);

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

        //Validar
        $errores = $propiedad->validar();

        //Revisar que el array de errores este vacio
        if(empty($errores)){

            //Crear carpeta
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            
            // Guarda en la base de datod
            $propiedad->guardar();
        }
    }
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="../index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data">
            
            <?php include '../../includes/templates/formularioPropiedades.php'; ?>

            <input type="submit" value="Crear Propirdad" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>