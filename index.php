<?php
require_once "models/Cliente.php";

$cliente = new Cliente();
$buscar = trim($_GET["buscar"] ?? "");
$clientes = $cliente->listar($buscar);
$msg = $_GET["msg"] ?? "";

$mensajes = [
    "creado"      => "Cliente registrado correctamente.",
    "actualizado" => "Cliente actualizado correctamente.",
    "eliminado"   => "Cliente eliminado correctamente.",
];

function e($txt) { return htmlspecialchars((string)$txt, ENT_QUOTES, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Clientes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<div class="contenedor">
    <h1>Gestión de Clientes</h1>

    <?php if (isset($mensajes[$msg])): ?>
        <div class="alerta exito"><?= $mensajes[$msg] ?></div>
    <?php endif; ?>

    <div class="barra">
        <form method="GET" class="buscador">
            <input type="text" name="buscar" placeholder="Buscar por cédula, nombre o email" value="<?= e($buscar) ?>">
            <button type="submit" class="btn">Buscar</button>
            <?php if ($buscar !== ""): ?><a href="index.php" class="btn gris">Limpiar</a><?php endif; ?>
        </form>
        <a href="form.php" class="btn verde">+ Nuevo cliente</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>#</th><th>Cédula</th><th>Nombres</th><th>Apellidos</th>
            <th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($clientes)): ?>
            <tr><td colspan="8" class="centro">No hay clientes registrados.</td></tr>
        <?php else: foreach ($clientes as $c): ?>
            <tr>
                <td><?= e($c["id"]) ?></td>
                <td><?= e($c["cedula"]) ?></td>
                <td><?= e($c["nombres"]) ?></td>
                <td><?= e($c["apellidos"]) ?></td>
                <td><?= e($c["email"]) ?></td>
                <td><?= e($c["telefono"]) ?></td>
                <td><?= e($c["direccion"]) ?></td>
                <td class="acciones">
                    <a href="form.php?id=<?= $c["id"] ?>" class="btn azul">Editar</a>
                    <form method="POST" action="eliminar.php" onsubmit="return confirm('¿Eliminar este cliente?');">
                        <input type="hidden" name="id" value="<?= $c["id"] ?>">
                        <button type="submit" class="btn rojo">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
