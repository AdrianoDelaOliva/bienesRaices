<main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="img/webp">
            <source srcset="build/img/destacada3.jpg" type="img/jpeg">
            <img src="build/img/destacada3.jpg" alt="imagen contacto" loading="lazy">
        </picture>
        
        <h2>Llene el formulario de Contacto</h2>
        <?php 
            if($mensaje) { ?>
                <p class="alerta exito"><?php echo $mensaje; ?></p>
        <?php } ?>
           
        
        
        ?>
        <form action="/contacto" class="formulario" method="POST">
            <fieldset>
                <legend>Informacion personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required>

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="contacto[mensaje]" required></textarea>

            </fieldset>

            <fieldset>
                <legend>Informacion Sobre la propiedad</legend>

                <label for="opciones">Vende o Compra</label>
                <select name="contacto[tipo]" id="opciones" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o presupuesto</label>
                <input type="number" placeholder="Tu precio o presupuesto" id="presupuesto" name="contacto[precio]" required>
            </fieldset>

            <fieldset>
                <legend>Informacion sobre la propiedad</legend>

                <p>Como desea ser Contactado</p>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Telefono</label>
                    <input name="contacto[contacto]" type="radio" value="telefono" id="contactar-telefono" required>

                    <label for="contactar-email">E-mail</label>
                    <input name="contacto[contacto]" type="radio" value="email" id="contactar-email" required>

                </div>
                <div id="contacto">
                </div>
            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">
        </form>
    </main>