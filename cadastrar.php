<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome     = $_POST['nomeC'] ?? '';
    $cpf      = $_POST['cpfC'] ?? '';
    $email    = $_POST['emailC'] ?? '';
    $senha    = $_POST['senhaC'] ?? '';
    $contato  = $_POST['contato'] ?? '';
    $endereco = $_POST['endereco'] ?? '';

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $tipo = 'comum';

        // 1. Grava na tabela 'pessoa'
        $sqlPessoa = "INSERT INTO pessoa (nome, email, cpf, senha, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmtPessoa = $conexao->prepare($sqlPessoa);
        $stmtPessoa->bind_param("sssss", $nome, $email, $cpf, $senhaHash, $tipo);

        if ($stmtPessoa->execute()) {
            // Pega o ID da pessoa que acabou de ser criada
            $pessoa_id = $conexao->insert_id;

            // 2. Grava na tabela 'tutor_animal' usando o mesmo ID
            $sqlTutor = "INSERT INTO tutor_animal (pessoa_id, contato, endereco) VALUES (?, ?, ?)";
            $stmtTutor = $conexao->prepare($sqlTutor);
            $stmtTutor->bind_param("iss", $pessoa_id, $contato, $endereco);
            $stmtTutor->execute();

            echo "<script>alert('Conta criada com sucesso!'); window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "Erro ao cadastrar: " . $conexao->error;
        }
    } else {
        echo "<script>alert('Preencha os campos obrigatórios!'); window.history.back();</script>";
    }
}
?>