<?php
// Clase de conexión a MySQL (XAMPP) usando PDO
class Database
{
    private string $host = "localhost";
    private string $dbName = "crud_clientes";
    private string $user = "root";      // usuario por defecto de XAMPP
    private string $password = "";      // contraseña por defecto de XAMPP
    private ?PDO $conexion = null;

    public function conectar(): PDO
    {
        if ($this->conexion === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
                $this->conexion = new PDO($dsn, $this->user, $this->password);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return $this->conexion;
    }
}
