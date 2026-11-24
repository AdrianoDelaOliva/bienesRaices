<?php
/** @var \Model\Vendedor $vendedor */
?>
<fieldset>
    <legend>Informacion general</legend>

    <label for="nombre" >Nombre</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido" >Apellido</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido" value="<?php echo s($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Información Extra</legend>
    <label for="telefono" >Telefono</label>
    <input type="tel" id="telefono" name="vendedor[telefono]" placeholder="telefono" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>