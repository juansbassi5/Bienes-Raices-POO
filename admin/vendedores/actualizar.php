<?php 
    require '../../includes/app.php';
    use App\Vendedores;
    estaAutenticado();

    // Validar que sea un ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener el arreglo del vendedor desde la DB
    $vendedor = Vendedores::find($id);

    // Arreglo con mensajes de errores
    $errores = Vendedores::getErrores();
   
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Asignar los valores
        $args = $_POST['vendedor'];

        // Sincronizar objeto en memoria con lo que el usuario escribió
        $vendedor->sincronizar($args);

        // validación
        $errores = $vendedor->validar();

        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>

    <a href="/admin" class="boton boton-azul">Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>        
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-azul">
    </form>
</main>

<?php 
    incluirTemplate('footer');
?>