<?php

session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $sql = "SELECT id, nome, senha, tipo FROM pessoa WHERE email = ?";
        $stmt = $conexao->prepare($sql);

        if (!$stmt) {
            die("Erro no SQL: " . $conexao->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            // Verifica a senha 
            if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {
                // Guarda os dados na sessão corretamente com sublinhado
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];

                // Redireciona para a página principal
                header("Location: index.php");
                exit;
            }
        }

        echo "<script>alert('E-mail ou senha incorretos!'); window.history.back();</script>";
    } else {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
    }
}
?>