<?php
session_start();

$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}


$usuarioLogado = $_SESSION['usuario_id'];



$result = $conn->query("
    SELECT 
        id, nome, data_nascimento, peso, altura, endereco,
        numero_casa, cep, celular, email, diagnostico
    FROM usuarios
    WHERE usuario_id = $usuarioLogado
    ORDER BY id ASC
");

echo "<h1>Seus Pacientes</h1>";
echo "<a href='formulario1.html'>+ Novo Cadastro </a><br><br>";
echo "<a href='login.php'> - Sair </a><br><br>";

while ($u = $result->fetch_assoc()) {

    echo "<div style='border:5px solid #ccc; padding:10px; margin-bottom:20px;'>";

    echo "<h2>{$u['nome']} (ID {$u['id']})</h2>";

    echo "<strong>Data de Nascimento:</strong> " . date('d/m/Y', strtotime($u['data_nascimento'])) . "<br>";

    echo "<strong>Peso:</strong> {$u['peso']} kg<br>";
    echo "<strong>Altura:</strong> {$u['altura']} m<br><br>";

    echo "<strong>Endereço:</strong> {$u['endereco']}, Nº {$u['numero_casa']}<br>";
    echo "<strong>CEP:</strong> {$u['cep']}<br><br>";

    echo "<strong>Celular:</strong> {$u['celular']}<br>";
    echo "<strong>E-mail:</strong> {$u['email']}<br><br>";

    echo "<strong>Diagnóstico:</strong><br>";
    echo nl2br($u['diagnostico']) . "<br><br>";

    // Arquivos
    $arquivos = $conn->query("
        SELECT * FROM arquivos WHERE usuario_id = {$u['id']}
    ");

    echo "<strong>Anexos:</strong>";

    if ($arquivos->num_rows > 0) {
        while ($arq = $arquivos->fetch_assoc()) {
            echo " <a href='{$arq['caminho']}' target='_blank'>Baixar PDF</a>";
        }
    } else {
        echo "Nenhum arquivo anexado.";
    }

    echo "<br>";

    echo "<a href='editar.php?id={$u['id']}'>Editar</a> | ";
    echo "<a href='excluir_usuario.php?id={$u['id']}' onclick='return confirm(\"Tem certeza?\");'>Excluir Usuário</a>";

    echo "</div>";
}
?>
