<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['senha'])) {

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $senhaDigitada = $_POST['senha'];

        if (!$email) {
            echo "E-mail inválido!";
            exit;
        }

        $instrucao = mysqli_prepare(
            $conexao,
            "SELECT id, email, senha, tipo FROM pessoa WHERE email = ?"
        );

        mysqli_stmt_bind_param($instrucao, "s", $email);
        mysqli_stmt_execute($instrucao);

        $resultado = mysqli_stmt_get_result($instrucao);
        $retorno = mysqli_fetch_assoc($resultado);

        if ($retorno && password_verify($senhaDigitada, $retorno['senha'])) {

            session_start();

            $_SESSION['email'] = $retorno['email'];
            $_SESSION['usuario_tipo'] = $retorno['tipo'];
            $_SESSION['id'] = $retorno['id'];
            echo "sucesso";

        } else {
            echo "Usuário ou senha incorretos!";
        }

    } else {
        echo "Preencha todos os campos!";
    }
}

mysqli_close($conexao);
?>