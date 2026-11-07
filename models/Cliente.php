<?php
require_once __DIR__ . "/../config/Database.php";

// Clase modelo Cliente: encapsula atributos y operaciones CRUD
class Cliente
{
    // Atributos privados (encapsulamiento)
    private ?int $id = null;
    private string $cedula = "";
    private string $nombres = "";
    private string $apellidos = "";
    private string $email = "";
    private string $telefono = "";
    private string $direccion = "";

    private PDO $db;
    private string $tabla = "clientes";

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    // ---------- Getters y Setters ----------
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getCedula(): string { return $this->cedula; }
    public function setCedula(string $cedula): void { $this->cedula = trim($cedula); }

    public function getNombres(): string { return $this->nombres; }
    public function setNombres(string $nombres): void { $this->nombres = trim($nombres); }

    public function getApellidos(): string { return $this->apellidos; }
    public function setApellidos(string $apellidos): void { $this->apellidos = trim($apellidos); }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = trim($email); }

    public function getTelefono(): string { return $this->telefono; }
    public function setTelefono(string $telefono): void { $this->telefono = trim($telefono); }

    public function getDireccion(): string { return $this->direccion; }
    public function setDireccion(string $direccion): void { $this->direccion = trim($direccion); }

    // ---------- Creación de clientes ----------
    public function crear(): bool
    {
        $sql = "INSERT INTO {$this->tabla} (cedula, nombres, apellidos, email, telefono, direccion)
                VALUES (:cedula, :nombres, :apellidos, :email, :telefono, :direccion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->datos());
    }

    // ---------- Lectura de clientes ----------
    public function listar(string $buscar = ""): array
    {
        if ($buscar !== "") {
            $sql = "SELECT * FROM {$this->tabla}
                    WHERE cedula LIKE :b OR nombres LIKE :b OR apellidos LIKE :b OR email LIKE :b
                    ORDER BY id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":b" => "%$buscar%"]);
        } else {
            $stmt = $this->db->query("SELECT * FROM {$this->tabla} ORDER BY id DESC");
        }
        return $stmt->fetchAll();
    }

    // ---------- Busqueda por id ----------
    public function buscarPorId(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tabla} WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $fila = $stmt->fetch();
        if (!$fila) {
            return false;
        }
        $this->setId((int)$fila["id"]);
        $this->setCedula($fila["cedula"]);
        $this->setNombres($fila["nombres"]);
        $this->setApellidos($fila["apellidos"]);
        $this->setEmail($fila["email"]);
        $this->setTelefono($fila["telefono"] ?? "");
        $this->setDireccion($fila["direccion"] ?? "");
        return true;
    }

    // ---------- Actualizar Cliente ----------
    public function actualizar(): bool
    {
        $sql = "UPDATE {$this->tabla}
                SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos,
                    email = :email, telefono = :telefono, direccion = :direccion
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $datos = $this->datos();
        $datos[":id"] = $this->id;
        return $stmt->execute($datos);
    }

    // ---------- Borrar Cliente ----------
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->tabla} WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    // ---------- Validaciones del Formulario ----------
    public function validar(): array
    {
        $errores = [];
        if (!preg_match('/^\d{10}$/', $this->cedula)) $errores[] = "La cédula debe tener 10 dígitos.";
        if ($this->nombres === "") $errores[] = "Los nombres son obligatorios.";
        if ($this->apellidos === "") $errores[] = "Los apellidos son obligatorios.";
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
        if ($this->telefono !== "" && !preg_match('/^\d{7,10}$/', $this->telefono)) $errores[] = "El teléfono debe tener entre 7 y 10 dígitos.";
        if ($this->cedulaExiste()) $errores[] = "Ya existe un cliente con esa cédula.";
        return $errores;
    }
    // ---------- Validaciones de Cédula Existente ----------
    private function cedulaExiste(): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->tabla} WHERE cedula = :c AND id <> :id");
        $stmt->execute([":c" => $this->cedula, ":id" => $this->id ?? 0]);
        return $stmt->fetchColumn() > 0;
    }

    private function datos(): array
    {
        return [
            ":cedula"    => $this->cedula,
            ":nombres"   => $this->nombres,
            ":apellidos" => $this->apellidos,
            ":email"     => $this->email,
            ":telefono"  => $this->telefono,
            ":direccion" => $this->direccion,
        ];
    }
}
