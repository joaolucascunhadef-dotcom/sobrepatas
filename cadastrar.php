
<?php

include "conexao.php";

$nome = $_POST['nomeC'];
$cpf = $_POST['cpfC'];
$email = $_POST['emailC'];
$senha = $_POST['senhaC'];
$senha2 = $_POST['senhaC2'];

if ($senha != $senha2) {
    die("As senhas não coincidem!");
}

$senha = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO pessoa (cpf, email, nome, senha, tipo)
        VALUES (?, ?, ?, ?, 'comum')";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param($stmt, "ssss", $cpf, $email, $nome, $senha);

if (mysqli_stmt_execute($stmt)) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar!";
}

mysqli_close($conexao);

?>
