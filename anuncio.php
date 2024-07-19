<?php

    require 'includes/app.php';
    use App\Propiedad;

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /bienesraices/index.php');
    }

    $propiedad = Propiedad::find($id);

    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad->titulo; ?></h1>
        <img loading="lazy" src="/bienesraices/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
        <div class="resumen-propiedad">
            <p class="precio">G$<?php echo $propiedad->precio; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio" loading="lazy">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
            </ul>
            <p><?php echo $propiedad->descripcion; ?></p>
        </div>
    </main>
<?php
    incluirTemplate('footer');
?>