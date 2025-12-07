<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
</head>
<body>

<h1>Cadastro de Usuário</h1>

<form method="post" action="salvar_login.php">
    Nome: <br> <input type="text" name="nome" required><br><br>
    E-mail:<br> <input type="email"  name="email" required><br><br>
    Senha: <br> <input type="password" name="senha" required><br><br>

    <button type="submit">Enviar</button> <br><br>
</form>

<a href="login.php">Voltar</a>

</body>
</html>

