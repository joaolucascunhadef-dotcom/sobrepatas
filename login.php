<?php
    session_start();
    include 'conexao.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) || empty($senha)) {
        $_SESSION['erro'] = "Preencha o login e a senha.";
        header("Location: login_form.php");
        exit();
    }

    $sql = "SELECT p.id, p.nome, p.email, p.senha,
                   f.pessoa_id AS ong_id, f.cargo, f.usuario,
                   t.pessoa_id AS tutor_id
            FROM pessoa p
            LEFT JOIN funcionario_ong f ON f.pessoa_id = p.id
            LEFT JOIN tutor_animal t ON t.pessoa_id = p.id
            WHERE p.email = '$login' OR f.usuario = '$login'";

    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $tupla = mysqli_fetch_assoc($resultado);

        if ($senha == $tupla['senha']) {
            $_SESSION['pessoa_id'] = $tupla['id'];
            $_SESSION['nome'] = $tupla['nome'];

            if (!empty($tupla['ong_id'])) {
                $_SESSION['perfil'] = 'ong';
                $_SESSION['funcionario_ong_pessoa_id'] = $tupla['ong_id'];
                $_SESSION['cargo'] = $tupla['cargo'];
                $_SESSION['msg'] = "Bem-vindo, " . $tupla['nome'] . "!";
                header("Location: listar.php");
            } elseif (!empty($tupla['tutor_id'])) {
                $_SESSION['perfil'] = 'adotante';
                $_SESSION['tutor_animal_pessoa_id'] = $tupla['tutor_id'];
                $_SESSION['msg'] = "Bem-vindo, " . $tupla['nome'] . "!";
                header("Location: index.html");
            } else {
                $_SESSION['erro'] = "Usuário sem perfil vinculado.";
                header("Location: login_form.php");
            }
        } else {
            $_SESSION['erro'] = "Senha incorreta.";
            header("Location: login_form.php");
        }
    } else {
        $_SESSION['erro'] = "Usuário não encontrado.";
        header("Location: login_form.php");
    }

    mysqli_close($conexao);
?>