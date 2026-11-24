<?php
session_start();
include 'conexao.php';

$sql_tipos = "SELECT id, nome FROM tipo_animal ORDER BY nome ASC";
$tipos = mysqli_query($conexao, $sql_tipos);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap">
    <title>SobrePatas - Cadastrar animal</title>
    <link rel="stylesheet" href="criar.css">

    <script>
        ! function () {
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
            <h1 class="error-title">Cadastrar novo animal</h1>
            <div class="error-description" style="text-align: left;">
                <?php
                if (!empty($_SESSION['erro'])) {
                    echo '<div class="alert danger"><span class="ico"><svg viewBox="0 0 24 24"><path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"></path><path d="m22 4-10 10-3-3"></path></svg></span><div class="body"><div class="title">Erro</div>' . $_SESSION['erro'] . '</div><button class="close" aria-label="Dismiss"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg></button></div>';
                    unset($_SESSION['erro']);
                }
                if (!empty($_SESSION['msg'])) {
                    echo '<div class="alert success"><span class="ico"><svg viewBox="0 0 24 24"><path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"></path><path d="m22 4-10 10-3-3"></path></svg></span><div class="body"><div class="title">Sucesso</div>' . $_SESSION['msg'] . '</div><button class="close" aria-label="Dismiss"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg></button></div>';
                    unset($_SESSION['msg']);
                }
                ?>

                <form action="salvar_animal.php" method="POST">
                    <p>
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="input" required autofocus>
                    </p>
                    <p>
                        <label for="tipo_animal_id">Tipo de animal:</label>
                        <select id="tipo_animal_id" name="tipo_animal_id" class="input" required>
                            <option value="">Selecione</option>
                            <option value="Macho">Cão</option>
                            <option value="Fêmea">Gato</option>
                        </select>
                    </p>
                    <p>
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" class="input" required>
                            <option value="">Selecione</option>
                            <option value="Macho">Macho</option>
                            <option value="Fêmea">Fêmea</option>
                        </select>
                    </p>
                    <p>
                        <label for="idade">Idade:</label>
                        <input type="text" id="idade" name="idade" class="input" required>   
                    </p>
                    <p>
                        <label for="raca">Raça:</label>
                        <input type="text" id="raca" name="raca" class="input" required>
                    </p>
                    <p>
                        <label for="foto">Foto:</label>
                        <input type="text" id="foto" name="foto" class="input"
                        placeholder="URL da foto do animal">
                    </p>
                    <p>
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="input"
                            placeholder="Breve descrição do animal">
                    </p>
                    <p>
                        <button type="submit" class="btn btn--primary">Adicionar animal</button>
                        <a href="lista_animais.php"><button type="button" class="btn btn--secondary">Voltar</button></a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>