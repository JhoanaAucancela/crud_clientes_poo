<?php
require_once "models/Cliente.php";

$cliente = new Cliente();
$errores = [];
$esEdicion = false;

// Si viene un id por GET, cargamos el cliente para editar
if (isset($_GET["id"])) {
    $esEdicion = $cliente->buscarPorId((int)$_GET["id"]);
    if (!$esEdicion) {
        header("Location: index.php");
        exit;
    }
}

// Procesar envío del formulario (crear o actualizar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = !empty($_POST["id"]) ? (int)$_POST["id"] : null;
    $esEdicion = $id !== null;

    $cliente->setId($id);
    $cliente->setCedula($_POST["cedula"] ?? "");
    $cliente->setNombres($_POST["nombres"] ?? "");
    $cliente->setApellidos($_POST["apellidos"] ?? "");
    $cliente->setEmail($_POST["email"] ?? "");
    $cliente->setTelefono($_POST["telefono"] ?? "");
    $cliente->setDireccion($_POST["direccion"] ?? "");

    $errores = $cliente->validar();

    if (empty($errores)) {
        if ($esEdicion) {
            $cliente->actualizar();
            header("Location: index.php?msg=actualizado");
        } else {
            $cliente->crear();
            header("Location: index.php?msg=creado");
        }
        exit;
    }
}

function e($txt) { return htmlspecialchars((string)$txt, ENT_QUOTES, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $esEdicion ? "Editar" : "Nuevo" ?> cliente</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="contenedor angosto">
    <h1><?= $esEdicion ? "Editar cliente" : "Nuevo cliente" ?></h1>

    <?php if (!empty($errores)): ?>
        <div class="alerta error">
            <ul><?php foreach ($errores as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="formulario">
        <input type="hidden" name="id" value="<?= e($cliente->getId()) ?>">

        <label>Cédula *</label>
        <input type="text" name="cedula" maxlength="10" required value="<?= e($cliente->getCedula()) ?>">

        <label>Nombres *</label>
        <input type="text" name="nombres" required value="<?= e($cliente->getNombres()) ?>">

        <label>Apellidos *</label>
        <input type="text" name="apellidos" required value="<?= e($cliente->getApellidos()) ?>">

        <label>Email *</label>
        <input type="email" name="email" required value="<?= e($cliente->getEmail()) ?>">

        <label>Teléfono</label>
        <input type="text" name="telefono" maxlength="10" value="<?= e($cliente->getTelefono()) ?>">

        <label>Dirección</label>
        <textarea name="direccion" rows="3"><?= e($cliente->getDireccion()) ?></textarea>

        <div class="botones">
            <button type="submit" class="btn verde"><?= $esEdicion ? "Actualizar" : "Guardar" ?></button>
            <a href="index.php" class="btn gris">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
