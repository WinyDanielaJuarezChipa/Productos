<?php
require_once __DIR__ . '/productos/functions.php';
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="css/styles.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Restaurante</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
    <center>
    <div class="container mt-4">
        <h2>Sistema de Gestión de Restaurante</h2>
        <div class="btn-group">
            <form action="clientes/index.php" method="post">
             <button type="submit" class="btn btn-primary mb-3">Gestión de Clientes</button>
            </form>
            <form action="productos/index.php" method="post">
             <button type="submit" class="btn btn-primary mb-3">Gestión de Productos</button>
            </form>
        </div>
    </div>
    </center>
</body>
<head>
</head>
</html>