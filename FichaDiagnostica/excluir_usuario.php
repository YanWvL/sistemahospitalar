<?php

if (!isset($_GET['id'])) {
    die("ID do usuário não informado.");
}

$id = intval($_GET['id']); 


$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


$conn->query("DELETE FROM arquivos WHERE usuario_id = $id");


$sql = "DELETE FROM usuarios WHERE id = $id";

if ($conn->query($sql) === TRUE) {


    header("Location: listar.php"); 
    exit();

} else {
    echo "Erro ao excluir: " . $conn->error;
}

$conn->close();
?>
