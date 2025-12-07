<?php
$conn = new mysqli("localhost", "root", "senha", "formularioDiagnostico_db");



$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id === 0) {
    die("ID inválido.");
}

$sql = "SELECT * FROM usuarios WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$usuario = $result->fetch_assoc();

// pega anexos
$arquivos = $conn->query("SELECT * FROM arquivos WHERE usuario_id = $id");
?>

<h1>Editar Usuário</h1>

<form action="salvar_edicao.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

Nome: 
<input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>"><br><br>

Data Nascimento: 
<input type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>"><br><br>

Peso:
<input type="number" step="0.01" name="peso" value="<?php echo $usuario['peso']; ?>"><br><br>

Altura:
<input type="number" step="0.01" name="altura" value="<?php echo $usuario['altura']; ?>"><br><br>

Endereço:
<input type="text" name="endereco" value="<?php echo htmlspecialchars($usuario['endereco']); ?>"><br><br>

Nº:
<input type="text" name="numero_casa" value="<?php echo $usuario['numero_casa']; ?>"><br><br>

CEP:
<input type="text" name="cep" value="<?php echo $usuario['cep']; ?>"><br><br>

Celular:
<input type="text" name="celular" value="<?php echo $usuario['celular']; ?>"><br><br>

Email:
<input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>"><br><br>

Diagnóstico:<br>
<textarea name="diagnostico" rows="10" cols="60"><?php echo htmlspecialchars($usuario['diagnostico']); ?></textarea><br><br>

<h3>Anexos Existentes:</h3>
<?php while ($arq = $arquivos->fetch_assoc()) { ?>
    <p>
        <a href="<?php echo $arq['caminho']; ?>" target="_blank">Abrir PDF</a>
         — 
        <a style="color:red;" 
           href="excluir_arquivo.php?id=<?php echo $arq['id']; ?>&usuario=<?php echo $usuario['id']; ?>"
           onclick="return confirm('Deseja realmente excluir este arquivo?');">
            Excluir
        </a>
    </p>
<?php } ?>

<h3>Adicionar novos anexos:</h3>
<input type="file" name="arquivo[]" multiple accept="application/pdf"><br><br>

<button type="submit">Salvar Alterações</button> <br>
<a href='listar.php?id={$u['id']}'>Voltar</a>

</form>
