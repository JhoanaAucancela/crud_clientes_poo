<?php
require_once "models/Cliente.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["id"])) {
    $cliente = new Cliente();
    $cliente->eliminar((int)$_POST["id"]);
    header("Location: index.php?msg=eliminado");
    exit;
}

header("Location: index.php");
exit;
