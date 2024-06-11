<?php
    require '../../includes/app.php';

    use App\Propiedad;

    estaAutenticado();

    //Base de datos//
    $db = conectarDB();

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores
    $errores = [];

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedores_id = "";

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST);

        $propiedad->guardar();

        //debuguear($propiedad);

        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        //echo "<pre>";
        //var_dump($_FILES);
        //echo "</pre>";

        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedores_id']);
        $creado = date('Y/m/d');

        //Asignar files hacia una variable
        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = "El título es Obligatorio";
        }
        if(!$precio){
            $errores[] = "El precio es Obligatorio";
        }
        if(strlen($descripcion) < 50){
            $errores[] = "La descripcion es Obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$habitaciones){
            $errores[] = "El numero de habitaciones es Obligatorio";
        }
        if(!$wc){
            $errores[] = "El numero de baños es Obligatorio";
        }
        if(!$estacionamiento){
            $errores[] = "El numero de estacionamiento es Obligatorio";
        }
        if(!$vendedores_id){
            $errores[] = "Elige al vendedor";
        }
        if(!$imagen['name']){
            $errores[] = "La Imagen es Obligatoria";
        }

        //Validar imagen por tamaño (1mb maximo)
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida){
            $errores[] = 'La Imagen es muy pesada';
        }

        //echo "<pre>";
        //var_dump($errores);
        //echo "</pre>";

        //Revisar que el array de errores este vacio
        if(empty($errores)){

            /** SUBIDA DE ARCHIVOS */

            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Generar nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . $imagen['name'];

            //subir archivo
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            //Insertar en la Base de Datos//
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) 
            VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id')";

            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                //echo "Insertado Correctamente";
                //Redireccionar al usuario
                header('Location: /bienesraices/admin/index.php?resultado=1');
            }
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
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" cols="30" rows="10"><?php echo $descripcion ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="10" value="<?php echo $habitaciones ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="10" value="<?php echo $wc ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="10" value="<?php echo $estacionamiento ?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedores_id">
                    <option value="" disabled selected>--SELECCIONE--</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : '' ?> value="<?php echo $vendedor['id'] ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>

            </fieldset>

            <input type="submit" value="Crear Propirdad" class="boton boton-verde">

        </form>
    </main>
<?php
    incluirTemplate('footer');
?>