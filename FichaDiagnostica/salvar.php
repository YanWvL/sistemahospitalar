<?php
session_start();


$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}


$usuario_id = $_SESSION['usuario_id'];



$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];
$endereco = $_POST['endereco'];
$numero_casa = $_POST['numero_casa'];
$cep = $_POST['cep'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$diagnostico = $_POST['diagnostico'];


$sql = "INSERT INTO usuarios 
(nome, data_nascimento, peso, altura, endereco, numero_casa, cep, celular, email, diagnostico, usuario_id)
VALUES 
('$nome', '$data_nascimento', '$peso', '$altura', '$endereco', '$numero_casa', '$cep', '$celular', '$email', '$diagnostico', '$usuario_id')";

if ($conn->query($sql) === TRUE) {

    $idRegistro = $conn->insert_id; 

   

    
    if (!file_exists("uploads/$idRegistro")) {
        mkdir("uploads/$idRegistro", 0777, true);
    }

    foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmpFile) {

        if ($_FILES['arquivo']['error'][$index] === UPLOAD_ERR_OK) {

            $nomeOriginal = $_FILES['arquivo']['name'][$index];
            $destino = "uploads/$idRegistro/" . $nomeOriginal;

            move_uploaded_file($tmpFile, $destino);

            $conn->query("INSERT INTO arquivos (usuario_id, caminho) 
                          VALUES ($idRegistro, '$destino')");
        }
    }

    echo "Cadastro salvo com sucesso!";
    echo "<br><a href='listar.php'>Ver Pacientes</a>";

} 
else {
    echo "Erro ao salvar usuário: " . $conn->error;
}

$conn->close();
?>
