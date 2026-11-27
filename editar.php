<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="editar.css">

</head>
<body>
    
</body>
</html>

<?php
    session_start();
    include 'conexao.php';
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (empty($id)) {
        $_SESSION['erro'] = "ID do animal não fornecido.";
        header("Location: listar.php");
        exit();
    }

    //sql para buscar o animal no banco
    $sql = "SELECT * FROM animal WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 0) {
        $_SESSION['erro'] = "Animal não encontrado!";
        header("Location: listar.php");
        exit();
    }

    while($tupla = mysqli_fetch_assoc($resultado)) {
        $nome = $tupla["nome"] ?? '';
        $tipo_animal_id = $tupla["tipo_animal_id"] ?? '';
        $sexo = $tupla["sexo"] ?? '';
        $idade = $tupla["idade"] ?? '';
        $raca = $tupla["raca"] ?? '';
        $foto = $tupla["foto"] ?? '';
        $descricao = $tupla["descricao"] ?? '';
    }

    mysqli_close($conexao);

    
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap">
    <title>Exemplo CRUD</title>
    <script>
        ! function() {
            try {
                var t = localStorage.getItem("dash26-theme"),
                    e = window.matchMedia("(prefers-color-scheme: dark)").matches;
                document.documentElement.setAttribute("data-theme", t || (e ? "dark" : "light"))
            } catch (t) {
                document.documentElement.setAttribute("data-theme", "light")
            }
        }()
    </script>
</head>

<body>
    <div class="error-shell">
        <div class="error-card"><span class="error-eyebrow"></span>
            <h1 class="error-title">Editar animal</h1>
            <div class="error-description" style="text-align: left;">
                <?php
                    if (!empty($_SESSION['erro'])) {
                        echo '<div class="alert danger"><span class="ico"><svg viewBox="0 0 24 24"><path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"></path><path d="m22 4-10 10-3-3"></path></svg></span><div class="body"><div class="title">Erro</div>'.$_SESSION['erro'].'</div><button class="close" aria-label="Dismiss"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg></button></div>';
                        unset($_SESSION['erro']);
                    }
                    if (!empty($_SESSION['msg'])) {
                        echo '<div class="alert success"><span class="ico"><svg viewBox="0 0 24 24"><path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"></path><path d="m22 4-10 10-3-3"></path></svg></span><div class="body"><div class="title">Sucesso</div>'.$_SESSION['msg'].'</div><button class="close" aria-label="Dismiss"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg></button></div>';
                        unset($_SESSION['msg']);
                    }
                ?>
                <form action="atualizar.php" method="POST">
                    <p>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($foto, ENT_QUOTES); ?>">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="input" value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>" required autofocus>
                    </p>
                    <p>
                        <label for="tipo_animal_id">Tipo de animal:</label>
                        <select id="tipo_animal_id" name="tipo_animal_id" class="input" required>
                            <option value="">Selecione</option>
                            <option value="1" <?php echo ($tipo_animal_id == 1) ? 'selected' : ''; ?>>Cão</option>
                            <option value="2" <?php echo ($tipo_animal_id == 2) ? 'selected' : ''; ?>>Gato</option>
                        </select>
                    </p>
                    <p>
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" class="input" required>
                            <option value="">Selecione</option>
                            <option value="Macho" <?php echo ($sexo == 'Macho') ? 'selected' : ''; ?>>Macho</option>
                            <option value="Fêmea" <?php echo ($sexo == 'Fêmea') ? 'selected' : ''; ?>>Fêmea</option>
                        </select>
                    </p>
                    <p>
                        <label for="idade">Idade:</label>
                        <input type="text" id="idade" name="idade" class="input" value="<?php echo htmlspecialchars($idade, ENT_QUOTES); ?>" required>
                    </p>
                    <p>
                        <label for="raca">Raça:</label>
                        <input type="text" id="raca" name="raca" class="input" value="<?php echo htmlspecialchars($raca, ENT_QUOTES); ?>" required>
                    </p>
                    <p>
                        <label for="foto">Nova foto (opcional):</label>
                        <input type="file" name="foto" id="foto" accept="image/*" class="input">
                        <?php if (!empty($foto)) { ?>
                            <small style="display:block; margin-top:6px; opacity:0.8;">Foto atual: <?php echo htmlspecialchars($foto, ENT_QUOTES); ?></small>
                        <?php } ?>
                    </p>
                    <p>
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="input" value="<?php echo htmlspecialchars($descricao, ENT_QUOTES); ?>" placeholder="Breve descrição do animal">
                    </p>
                        <button type="submit" class="btn btn--primary">Atualizar animal</button>
                        <a href="listar.php"><button type="button" class="btn btn--secondary">Voltar</button></a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>