<?php
// 1. Incluir conexión a la base de datos
require_once '../config/database.php';

// 2. Inicializar variables
$producto = [
    'nombre' => '',
    'precio' => '',
    'descripcion' => '',
    'categoria' => ''
];
$esNuevo = true;
$mensaje = '';

// 3. Si es edición, cargar datos del cliente
if (isset($_GET['id'])) {
    $esNuevo = false;
    $id = new MongoDB\BSON\ObjectId($_GET['id']);
    $productoExistente = $db->productos->findOne(['_id' => $id]);
    if ($productoExistente) {
        $producto = (array) $productoExistente;
    }
}

// 4. Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $producto = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'descripcion' => $_POST['descripcion'],
        'categoria' => $_POST['categoria']
    ];

    // Validar datos
    if (empty($producto['nombre']) || empty($producto['precio'])) {
        $mensaje = 'Por favor, completa los campos obligatorios.';
    } else {
        try {
            if ($esNuevo) {
                // Insertar nuevo cliente
                $producto['fecha_registro'] = date('Y-m-d');
                $db->productos->insertOne($producto);
            } else {
                // Actualizar cliente existente
                $db->productos->updateOne(
                    ['_id' => $id],
                    ['$set' => $producto]
                );
            }
            // Redireccionar a la lista
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $mensaje = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $esNuevo ? 'Nuevo Producto' : 'Editar Producto'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="<https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css>" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2><?php echo $esNuevo ? 'Nuevo Producto' : 'Editar Producto'; ?></h2>

                <?php if ($mensaje): ?>
                    <div class="alert alert-danger">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Producto*: </label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                               value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br></br>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio*:</label>
                        <input type="text" class="form-control" id="precio" name="precio"
                               value="<?php echo htmlspecialchars($producto['precio']); ?>" required><br></br>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion: </label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                               value="<?php echo htmlspecialchars($producto['descripcion']); ?>"><br></br>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select name="categoria" id="categoria" class="form-control">
                            <option value="bebidas">Bebidas</option>
                            <option value="hamburguesas">Hamburguesas</option>
                            <option value="jugos">Jugos</option>
                            <option value="extras">Extras</option>
                            <option value="postres">Postres</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js>"></script>
</body>
</html>
