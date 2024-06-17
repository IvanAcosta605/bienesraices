<?php

    use App\Propiedad;

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
    $errores = [];

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Asugnar los atributos
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);
        debuguear($propiedad);

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

            $nombreImagen = '';

            /** SUBIDA DE ARCHIVOS */

            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            if($imagen['name']){
                //Eliminar la imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Generar nombre unico
                $nombreImagen = md5(uniqid(rand(), true)) . $imagen['name'];

                //subir archivo
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            } else{
                $nombreImagen = $propiedad['imagen'];
            }

            //Insertar en la Base de Datos//
            $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', 
            descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, 
            vendedores_id = {$vendedores_id} WHERE id = {$id}";

            //echo $query;
            //exit;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                //echo "Insertado Correctamente";
                //Redireccionar al usuario
                header('Location: /bienesraices/admin/index.php?resultado=2');
            }
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