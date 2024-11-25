<?php
// 1. Incluir conexión a la base de datos
require_once '../config/database.php';

// 2. Función para obtener todos los clientes
function obtenerProductos() {
    global $db;
    return $db->productos->find([], ['sort' => ['nombre' => 1]]);
}

// 3. Función para eliminar cliente
if (isset($_POST['eliminar'])) {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $db->productos->deleteOne(['_id' => $id]);
    header('Location: index.php');
    exit;
}

// 4. Obtener lista de clientes
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  </head>
<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col">
        <h2>Lista de productos</h2>
        <link rel="stylesheet" href="css/styles.css">
        <a href="editar.php" class="btn btn-primary mb-3">
          Añadir Nuevo Producto
        </a>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Disponible</th>
              <th></th> </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $producto): ?>
              <tr>
              <td><?php echo htmlspecialchars($producto->nombre); ?></td>
              <td><?php echo htmlspecialchars($producto->precio); ?></td>
              <td><?php echo htmlspecialchars($producto->descripcion); ?></td>
              <td><?php echo htmlspecialchars($producto->categoria); ?></td>
              <td>
                  <a href="editar.php?id=<?php echo $producto->_id; ?>" class="btn btn-sm btn-warning">
                    Editar
                  </a>
                  <form action="" method="POST" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $producto->_id; ?>">
                    <button type="submit" name="eliminar" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro que desea eliminar el producto?');">
                      Eliminar
                    </button>
                  </form>
                  
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <a href='../index.php' class="btn btn-primary mb-3">
    Ir al Inicio
  </a>
  
  <script src="<https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js>"></script>
</body>
</html>