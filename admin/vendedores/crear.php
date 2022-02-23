<?php 
    require '../../includes/app.php';
    use App\Vendedores;
    estaAutenticado();

    $vendedor = new Vendedores;

    // Arreglo con mensajes de errores
    $errores = Vendedores::getErrores();
   
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Crear una nueva instancia
        $vendedor = new Vendedores($_POST['vendedor']);

        // Validar que no haya campos vacios
        $errores = $vendedor->validar();

        // No hay errores
        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/admin" class="boton boton-azul">Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>        
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-azul">
    </form>
</main>

<?php incluirTemplate('footer');?>