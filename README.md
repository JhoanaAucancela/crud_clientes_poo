# CRUD de Clientes – PHP POO + MySQL (XAMPP)

Aplicación web para **registrar, listar, buscar, editar y eliminar clientes**, desarrollada con **PHP orientado a objetos**, **MySQL** y **HTML/CSS**, ejecutada en **XAMPP**.

## Tecnologías

- PHP 8 (POO + PDO)
- MySQL / MariaDB (XAMPP)
- HTML5 y CSS3

## Estructura del proyecto

```
crud_clientes/
├── config/
│   └── Database.php    # Clase Database: conexión a MySQL con PDO
├── models/
│   └── Cliente.php     # Clase Cliente: atributos, getters/setters y métodos CRUD
├── css/
│   └── estilos.css     # Estilos de la interfaz
├── index.php           # Listado y búsqueda de clientes
├── form.php            # Formulario para crear y editar
├── eliminar.php        # Eliminación de clientes
├── database.sql        # Script de la base de datos
└── README.md
```

## Programación Orientada a Objetos aplicada

| Concepto | Dónde se aplica |
|---|---|
| **Clases** | `Database` y `Cliente` |
| **Encapsulamiento** | Atributos `private` en `Cliente`, accesibles mediante getters y setters |
| **Constructor** | `Cliente::__construct()` abre la conexión a la base de datos |
| **Métodos** | `crear()`, `listar()`, `buscarPorId()`, `actualizar()`, `eliminar()`, `validar()` |
| **Composición** | `Cliente` utiliza un objeto `Database` para conectarse |
| **Instanciación** | `$cliente = new Cliente();` en `index.php`, `form.php` y `eliminar.php` |

## Funcionalidades

- **Create:** registrar un cliente nuevo
- **Read:** listar todos los clientes y buscar por cédula, nombre o email
- **Update:** editar los datos de un cliente
- **Delete:** eliminar un cliente, con confirmación previa
- Validaciones: cédula de 10 dígitos y única, email válido, teléfono numérico
- Seguridad: consultas preparadas (contra inyección SQL) y `htmlspecialchars` (contra XSS)

## Instalación

1. Instalar [XAMPP](https://www.apachefriends.org/) e iniciar **Apache** y **MySQL**.
2. Copiar la carpeta `crud_clientes` en `C:\xampp\htdocs\`.
3. Abrir `http://localhost/phpmyadmin`, ir a la pestaña **SQL** y ejecutar el contenido de `database.sql`.
4. Si MySQL tiene contraseña, actualizarla en `config/Database.php`.
5. Abrir en el navegador: `http://localhost/crud_clientes/`

## Tabla `clientes`

| Campo | Tipo |
|---|---|
| id | INT, PK, AUTO_INCREMENT |
| cedula | VARCHAR(10), UNIQUE |
| nombres | VARCHAR(100) |
| apellidos | VARCHAR(100) |
| email | VARCHAR(120) |
| telefono | VARCHAR(15) |
| direccion | VARCHAR(200) |
| fecha_registro | TIMESTAMP |

## Autora

Jhoana – Aplicaciones Web, Semana 2
