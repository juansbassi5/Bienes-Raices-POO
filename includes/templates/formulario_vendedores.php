<fieldset>
            <legend>Informacion General</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre" value="<?php echo s( $vendedor->nombre ); ?>">

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido" value="<?php echo s( $vendedor->apellido ); ?>">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono" value="<?php echo s( $vendedor->telefono ); ?>">

        
</fieldset>