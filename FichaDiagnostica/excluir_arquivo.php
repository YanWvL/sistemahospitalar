<?php 
$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");


$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$usuario = isset($_GET['usuario']) ? (int) $_GET['usuario'] : 0;

if ($id === 0 || $usuario === 0) {
    die("Parâmetros inválidos.");
}


$sql = "SELECT caminho FROM arquivos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Arquivo não encontrado.");
}

$row = $result->fetch_assoc();
$caminho = $row['caminho'];


if (file_exists($caminho)) {
    unlink($caminho);
}

// remover do banco
$conn->query("DELETE FROM arquivos WHERE id = $id");


header("Location: editar.php?id=$usuario");
exit;
