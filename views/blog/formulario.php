<fieldset>
    <legend>Informacion general</legend>

    <label for="titulo" >Titulo</label>
    <input type="text" id="titulo" name="blogs[titulo]" placeholder="Titulo blog" value="<?php echo s($blogs->titulo); ?>">

    <label for="imagen" >Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="blogs[imagen]">
    <?php if ($blogs->imagen): ?>
        <img src="/imagenes/<?php echo $blogs->imagen ?>" alt="" class="imagen-small">
    <?php endif; ?>
    <label for="descripcion" >Descripcion:</label>
    <textarea name="blogs[descripcion]" id="descripcion"><?php echo s($blogs->descripcion); ?></textarea>

</fieldset>

<fieldset>
    <legend>Titular</legend>

    <label for="vendedor">Titulares</label>
    <select name="blogs[blogId]" id="vendedor">
        <option value="" selected disabled>-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor): ?>
            <option
                <?php echo $blogs->blogId === $vendedor->id ? 'selected' : '';  ?> 
                value="<?php echo s($vendedor->id); ?>"> 
                    <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido);?>
            </option>
        <?php endforeach; ?>

    </select>
</fieldset>