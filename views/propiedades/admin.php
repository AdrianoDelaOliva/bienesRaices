<?php
/** @var \Model\Propiedad[] $propiedades */
/** @var \Model\Vendedor[] $propiedades */
/** @var int|string|null $resultado */
?>
<main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php 
            if ($resultado) {
                $mensaje = mostrarNotificacion(intval($resultado));
                if ($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje); ?></p>
            <?php 
                } 
            } 
        ?>
            
        
                
        <a href="propiedades/crear" class="boton boton-verde">Nueva propiedad</a>
        <a href="vendedores/crear" class="boton boton-amarillo">Nuevo vendedor(a)</a>
        <a href="blog/crear" class="boton boton-verde">Nuevo blog</a>
        
        <h2>Propiedades</h2>
        <div class="tabla-responsive">

            <table class="propiedades">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                    
                </thead> 
                <tbody> <!-- Mostrar resultados-->
                    <?php foreach($propiedades as $propiedad): ?>
                        <tr>
                            <td> <?php echo $propiedad->id ?></td>
                            <td> <?php echo $propiedad->titulo?></td>
                            <td> <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-tabla" alt="imagen propiedad"></td>
                            <td>$ <?php echo $propiedad->precio ?></td>
                            <td>
                                <form action="/propiedades/eliminar" method="POST" class="w-100">
                                    
                                    <input type="hidden" name="id" value="<?php  echo $propiedad->id; ?>">
                                    <input type="hidden" name="tipo" value="propiedad">
                                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                                </form>
                                
                                <a href="propiedades/actualizar?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
        </div>

        <h2>Vendedores</h2>
        <div class="tabla-responsive">
        <table class="propiedades">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
                
            </thead> 
            <tbody> <!-- Mostrar resultados-->
                <?php foreach($vendedores as $vendedor): ?>
                    <tr>
                        <td> <?php echo $vendedor->id ?></td>
                        <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido?></td>
                        <td> <?php echo $vendedor->telefono?></td>
                        <td>
                            <form action="/vendedores/eliminar" method="POST" class="w-100">

                                <input type="hidden" name="id" value="<?php  echo $vendedor->id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>

                            <a href="/vendedores/actualizar?id=<?php echo $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <h2>Blog</h2>
        <div class="tabla-responsive">
        <table class="propiedades">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Titular</th>
                    <th>Descripcion</th>
                    <th>Imagen</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                
            </thead> 
            <tbody> <!-- Mostrar resultados-->
                <?php foreach($blogs as $blog): ?>
                    <tr>
                        <td> <?php echo $blog->id ?></td>
                        <td> <?php echo $blog->titulo ?></td>
                        <td>
                             <?php
                             foreach ($vendedores as $vendedor) {
                                 if ((string) $blog->blogId === (string) $vendedor->id) {
                                     echo s($vendedor->nombre . ' ' . $vendedor->apellido);
                                     break;
                                 }
                             }
                             ?>
                        </td>
                        <td> <?php echo $blog->descripcion?></td>
                        <td> <img src="/imagenes/<?php echo s($blog->imagen) ?>" class="imagen-tabla" alt="imagen propiedad"></td>
                        <td> <?php echo $blog->fecha?></td>
                        <td>
                            <form action="/blog/eliminar" method="POST" class="w-100">

                                <input type="hidden" name="id" value="<?php  echo $blog->id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>

                            <a href="/blog/actualizar?id=<?php echo $blog->id ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </main>