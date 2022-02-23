<?php

    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedores;
    use Intervention\Image\ImageManagerStatic as Image;


    estaAutenticado();


    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Consulta para obtener todos los vendedores
    $vendedores = Vendedores::all();
    
    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

   
    // Ejecutar el código después de que el usuario envié el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        // Asignar los atributos
        $args = $_POST['propiedad'];        

        $propiedad->sincronizar($args);
        
        // Validacion
        $errores = $propiedad->validar();


        //Subida de Archivos        
        // Generar un nombre único (hash)
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg" ;

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        
        // Revisar que el array de errores esté vacío
        if(empty($errores)){
            if($_FILES['propiedad']['tmp_name']['imagen']) {
            // Almacenar imagen 
            $image->save(CARPETA_IMAGENES . $nombreImagen);            
            }

            $propiedad->guardar();
        }
    }


    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>        
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php 
    incluirTemplate('footer');
?>

<!--No vendo casa pero si un Audi. Lo compré en color gris y no me gustó. Lo vendo a ese precio. Menos no.-->