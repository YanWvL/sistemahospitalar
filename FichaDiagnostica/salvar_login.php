
<?php

$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios_login (nome, email, senha_hash)
        VALUES ('$nome', '$email', '$senha_hash')";



if ($conn->query($sql) === TRUE) {
    echo "Usuário cadastrado com sucesso!" ;
    echo "<br> ";
   echo '<a href="login.php">Login</a>';

} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>