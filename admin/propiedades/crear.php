<?php 
    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedores;
    use Intervention\Image\ImageManagerStatic as Image;
    
    estaAutenticado();  


    $propiedad = new Propiedad();

    // Consulta para obtener todos los vendedores
    $vendedores = Vendedores::all();

   

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();
   
    // Ejecutar el código después de que el usuario envié el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        /** Crea una nueva instancia */
        $propiedad = new Propiedad($_POST['propiedad']);
        
        /** SUBIDA DE ARCHIVOS **/
        
        //Crear Carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }

        // Generar un nombre único (hash)
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg" ;

        // Setear la imagen
        // Realiza un resize a la imagen con intervention
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        // Validar
        $errores = $propiedad->validar();
       
        if(empty($errores)){

                

            // Crear la carpeta para subir imagenes
            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }
            
            //Guarda la Imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);   
            
            // Guarda en la base de datos
            $propiedad->guardar(); 

            
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>        
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php 
    incluirTemplate('footer');
?>