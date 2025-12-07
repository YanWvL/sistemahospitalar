<?php
session_start();

$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

$email = $_POST['email'];
$senhaDigitada = $_POST['senha'];

// Buscar usuário pelo e-mail
$sql = "SELECT * FROM usuarios_login WHERE email = '$email' LIMIT 1";
$result = $conn->query($sql);


if ($result->num_rows == 0) {
    echo "E-mail não encontrado!";
    exit;
}

$usuario = $result->fetch_assoc();


if (password_verify($senhaDigitada, $usuario['senha_hash'])) {

  
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];

    echo "Login realizado com sucesso!";
    echo '<br><a href="listar.php">Ir para o painel</a>';

} else {
    echo "Senha incorreta!";
    echo '<br><a href="login.php">Voltar</a>';
}

$conn->close();
?>
