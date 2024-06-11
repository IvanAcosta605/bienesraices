<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>
        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="sobre_nosotros" loading="lazy">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>25 Años de experiencia</blockquote>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore tenetur autem eos non provident. Iusto nam adipisci laborum quisquam inventore nesciunt ipsum, modi eum totam veniam tenetur enim, nihil ullam!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto animi sit impedit necessitatibus consectetur nihil nemo commodi laborum nobis? Et excepturi recusandae aperiam molestiae, voluptatum a tempore enim minima esse?
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, quibusdam ducimus est ipsum aliquam explicabo aspernatur quam amet similique! Atque minus consequatur vel officia enim natus recusandae harum voluptatum a?
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis alias dolorem accusamus eos quam. Tempore nemo aliquid perferendis ducimus animi, fugit nihil, quam debitis eligendi illum dicta voluptate ipsum alias.
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat enim unde rerum molestiae maxime commodi, alias placeat, dolorem officiis obcaecati consectetur sint aliquid quidem voluptatibus vero non laudantium voluptas nesciunt?
                </p>
            </div>
        </div>
    </main>
    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto eligendi doloremque est recusandae eveniet sed 
                    pariatur qui sapiente dignissimos tempore. Mollitia tempore cupiditate labore natus laborum commodi error autem 
                    animi.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto eligendi doloremque est recusandae eveniet sed 
                    pariatur qui sapiente dignissimos tempore. Mollitia tempore cupiditate labore natus laborum commodi error autem 
                    animi.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto eligendi doloremque est recusandae eveniet sed 
                    pariatur qui sapiente dignissimos tempore. Mollitia tempore cupiditate labore natus laborum commodi error autem 
                    animi.
                </p>
            </div>
        </div>
    </section>
<?php
    incluirTemplate('footer');
?>