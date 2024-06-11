<?php
    //Importar la conexion
    $db = conectarDB();

    //Consultar la BD
    $query = "SELECT * FROM propiedades LIMIT $limite";

    //Obtener resultado
    $resultado = mysqli_query($db, $query);
?>

<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
    <div class="anuncio">
            <img loading="lazy" src="/bienesraices/imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
        <div class="contenido-anuncio">
            <h3><?php echo $propiedad['titulo']; ?></h3>
            <p><?php echo $propiedad['descripcion']; ?></p>
            <p class="precio">G$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio" loading="lazy">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
            </ul>
            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad['id']; ?>">Ver Propirdad</a>
        </div><!--contenido-anuncio-->
    </div><!--anuncio-->
    <?php endwhile; ?>
</div><!--contenedor-anuncios-->
<?php
    //Cerrar la cobexion
    mysqli_close($db);
?>