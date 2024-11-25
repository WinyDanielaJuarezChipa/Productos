<?php
require_once __DIR__ . '/../config/database.php';
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));

}

function formatDate($date) {
    return $date->toDateTime()->format('Y-m-d');
}

function crearProductos($nombre, $precio, $descripcion, $categoria) {
    global $ProductoCollection;
    $resultado = $ProductoCollection->insertOne([
        'nombre' => sanitizeInput($nombre),
        'precio' => sanitizeInput($precio),
        'descripcion' => sanitizeInput($descripcion),
        'categoria' => sanitizeInput($categoria),
        
    ]);
    return $resultado->getInsertedId();
}

function obtenerProductos() {
    global $ProductoCollection;
    return $ProductoCollection->find();
}

function obtenerProductosPorId($_id) {
    global $ProductoCollection;
    return $ProductoCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($_id)]);
}

function actualizarProductos($_id, $nombre, $precio, $descripcion, $categoria) {
    global $ProductoCollection;
    $resultado = $ProductoCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($_id)],
        ['$set' => [
            'nombre' => sanitizeInput($nombre),
            'precio' => sanitizeInput($precio),
            'descripcion' => sanitizeInput($descripcion),
            'categoria' => sanitizeInput($categoria),
        ]]
    );
    return $resultado->getModifiedCount();
}

function eliminarProductos($_id) {
    global $ProductoCollection;
    $resultado = $ProductoCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_id)]);
    return $resultado->getDeletedCount();
}