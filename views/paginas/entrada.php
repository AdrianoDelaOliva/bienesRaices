<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $blogs->titulo; ?></h1>
        <img loading="lazy" src="/imagenes/<?php echo $blogs->imagen; ?>" alt="anuncio 1">

    <p class="informacion-meta">Escrito el: <span><?php echo $blogs->fecha; ?></span> por: <span><?php
        foreach ($vendedores as $vendedor) {
            if ((string) $blogs->blogId === (string) $vendedor->id) {
                echo s($vendedor->nombre . ' ' . $vendedor->apellido);
                break;
            }
        }
        ?>
    </span></p>
    
    <div class="resumen-propiedad">
        
        <p><?php echo $blogs->descripcion; ?></p>
    </div>
</main>