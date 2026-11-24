<?php foreach ($blogs as $blog): ?>
    <article class="entrada-blog">
                <div class="imagen">

                    <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="anuncio 1">
                </div>

                <div class="texto-entrada">
                    <a href="/entrada?id=<?php echo $blog->id;?>">
                        <h4><?php echo $blog->titulo; ?></h4>
                        <p class="informacion-meta">Escrito el: <span><?php echo $blog->fecha; ?></span> por <span><?php
                             foreach ($vendedores as $vendedor) {
                                 if ((string) $blog->blogId === (string) $vendedor->id) {
                                     echo s($vendedor->nombre . ' ' . $vendedor->apellido);
                                     break;
                                 }
                             }
                             ?></span></p>

                        <p>
                            <?php echo $blog->descripcion; ?>
                        </p>
                    </a>
                </div>
            </article>
    </article>
<?php endforeach; ?>
