<?php
$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

$id = $_POST['id'];
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

// atualizar dados
$sql = "
UPDATE usuarios SET
    nome='$nome',
    data_nascimento='$data_nascimento',
    peso='$peso',
    altura='$altura',
    endereco='$endereco',
    numero_casa='$numero_casa',
    cep='$cep',
    celular='$celular',
    email='$email',
    diagnostico='$diagnostico'
WHERE id=$id
";

$conn->query($sql);

// salvar novos anexos
if (!empty($_FILES['arquivo']['name'][0])) {

    if (!file_exists("uploads/$id")) {
        mkdir("uploads/$id", 0777, true);
    }

    foreach ($_FILES['arquivo']['tmp_name'] as $i => $tmpFile) {

        if ($_FILES['arquivo']['error'][$i] === UPLOAD_ERR_OK) {

            $nomeOriginal = $_FILES['arquivo']['name'][$i];
            $destino = "uploads/$id/" . $nomeOriginal;

            move_uploaded_file($tmpFile, $destino);

            $conn->query("INSERT INTO arquivos (usuario_id, caminho)
                          VALUES ($id, '$destino')");
        }
    }
}

echo "Dados atualizados com sucesso! <a href='listar.php'>Voltar</a>";

?>