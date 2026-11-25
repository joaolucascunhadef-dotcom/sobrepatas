<?php
    session_start();
    include('conexao.php');

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (empty($id)) {
        $_SESSION['erro'] = "ID do animal não fornecido.";
        header("Location: listar.php");
        exit();
    }

    // sql para excluir registro no banco
    $sql = "DELETE FROM animal WHERE id = $id";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['msg'] = "Animal excluído com sucesso.";
    } else {
        $_SESSION['erro'] = "Ocorreu um erro: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);

    // Se vier do X no index.html (fetch), responde simples e não redireciona
    if (isset($_GET['ajax'])) {
        echo "ok";
        exit();
    }

    header("Location: listar.php");
    exit();
?>