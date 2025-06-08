<?php
require_once "conexion.php";

class CategoriasModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom");
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM categorias");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre_categoria) VALUES (?)");
        $stmt->bind_param("s", $data['nombre_categoria']);
        return $stmt->execute();
    }

    public function update($data)
    {
        $stmt = $this->conn->prepare("UPDATE categorias SET nombre_categoria=? WHERE id_categoria=?");
        $stmt->bind_param("si", $data['nombre_categoria'], $data['id_categoria']);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id_categoria=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
