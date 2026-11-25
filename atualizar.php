<?php
    session_start();
    include 'conexao.php';

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $tipo_animal_id = $_POST['tipo_animal_id'];
    $sexo = $_POST['sexo'];
    $idade = $_POST['idade'];
    $raca = $_POST['raca'];
    $descricao = $_POST['descricao'];
    $foto = $_POST['foto_atual'] ?? '';

    if (empty($nome) || empty($tipo_animal_id) || empty($sexo) || empty($idade) || empty($raca)) {
        $_SESSION['erro'] = "Todos os campos são obrigatórios.";
        header("Location: editar.php?id=" . $id);
        exit();
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pasta = 'uploads/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $nomeArquivo = uniqid('animal_') . '.' . $extensao;
        $caminhoDestino = $pasta . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
            if (!empty($foto) && strpos($foto, 'uploads/') === 0 && file_exists($foto)) {
                unlink($foto);
            }
            $foto = $caminhoDestino;
        } else {
            $_SESSION['erro'] = "Erro ao enviar a foto.";
            header("Location: editar.php?id=" . $id);
            exit();
        }
    }

    //sql para atualizar no banco
    $sql = "UPDATE animal SET nome = '$nome', 
                tipo_animal_id = '$tipo_animal_id', 
                sexo = '$sexo', 
                idade = '$idade', 
                raca = '$raca', 
                foto = '$foto', 
                descricao = '$descricao' 
            WHERE id = $id";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['msg'] = "Animal atualizado com sucesso.";
        header("Location: listar.php");
    } else {
        $_SESSION['erro'] = "Ocorreu um erro: " . mysqli_error($conexao);
        header("Location: editar.php?id=" . $id);
    }

    mysqli_close($conexao);
?>