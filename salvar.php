    <?php
        session_start();
        include 'conexao.php';

        $nome = $_POST['nome'];
        $tipo_animal_id = $_POST['tipo_animal_id'];
        $sexo = $_POST['sexo'];
        $idade = $_POST['idade'];
        $raca = $_POST['raça'];
        $foto = $_POST['foto'];
        $descricao = $_POST['descricao'];
        
        $funcionario_ong_pessoa_id = $_SESSION['funcionario_ong_pessoa_id'] ?? 1;

        if (empty($nome) || empty($tipo_animal_id) || empty($sexo) || empty($idade) || empty($raca)) {
            $_SESSION['erro'] = "Todos os campos são obrigatórios.";
            header("Location: criar.php");
            exit();
        }

        //sql para inserir no banco
        $sql = "INSERT INTO animal (nome, tipo_animal_id, sexo, idade, raca, foto, descricao, funcionario_ong_pessoa_id)
                VALUES ('$nome', '$tipo_animal_id', '$sexo', '$idade', '$raca', '$foto', '$descricao', '$funcionario_ong_pessoa_id')";

        if (mysqli_query($conexao, $sql)) {
            $_SESSION['msg'] = "Animal cadastrado com sucesso.";
            header("Location: criar.php");
        } else {
            $_SESSION['erro'] = "Ocorreu um erro: " . mysqli_error($conexao);
            header("Location: criar.php");
        }

        mysqli_close($conexao);
    ?>