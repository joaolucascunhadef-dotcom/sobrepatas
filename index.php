<?php
session_start();

$logado = isset($_SESSION['usuario_id']) ? 'true' : 'false';
$ehFuncionario = (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario') ? 'true' : 'false';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Patas - Adoção de Animais</title>
    <link rel="stylesheet" href="adocao.css">


</head>

<body>

    <div class="pagina">
        <header class="banner">
            <div class="login_area">
                <img class="pata" src="pata.png" alt="Logo pata">
                <h1 class="titulo">Sobre patas</h1>
            </div>

            <a href="logout.php" id="sair" class="sair" style="display: none;">Sair</a>
            <a href="login.php" id="login" class="login">Login</a>
        </header>
        <section class="frase">
            <h1 class="titulo2">Todo animal merece um lar.</h1>
            <p class="subtitulo2">Conectamos animais abandonados a famílias amorosas</p>
        </section>

        <section class="visualizar_animais">
            <div class="container_filtros">
                <h2 class="tituloPrincipal">Animais disponíveis</h2>

                <div class="buscar">
                    <input class="pesquisa" type="text" name="pesquisa" id="pesquisa"
                        placeholder="Buscar por nome ou raça">

                    <div class="botoesFiltro">
                        <button class="tipos">Todos</button>
                        <button class="tipos">Gatos</button>
                        <button class="tipos">Cães</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="imagens_animais">
            <div class="aba_animal" data-tipo="cao">
                <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario'): ?>
                    <a href="excluir.php" class="botao_excluir" title="Excluir">&times;</a>
                <?php endif; ?>
                <img class="foto_animal" src="cachorro.png" alt="Foto do cachorro Bolinha">
                <div class="info_animal">
                    <div class="info_aba">
                        <h3 class="nome_animal">Bolinha</h3>
                        <button class="botao_favorito" id="fav_<?= $animal['id'] ?>" title="Favoritar">
                            <img src="estrela.png" alt="Favoritar">
                        </button>
                    </div>
                    <p class="raca_animal">SRD</p>
                    <p class="descricao_animal">Dócil e amoroso</p>
                    <p class="idade_animal">4 meses </p>
                    <p class="sexo_animal">Macho</p>

                    <button class="botao_solicitacao">Quero Adotar</button>
                </div>
            </div>

            <div class="aba_animal" data-tipo="gato">
                <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario'): ?>
                    <a href="excluir.php" class="botao_excluir" title="Excluir">&times;</a>
                <?php endif; ?>
                <img class="foto_animal" src="gato.png" alt="Foto do gato Cereal">
                <div class="info_animal">
                    <div class="info_aba">
                        <h3 class="nome_animal">Cereal</h3>
                        <button class="botao_favorito" id="fav_<?= $animal['id'] ?>" title="Favoritar">
                            <img src="estrela.png" alt="Favoritar">
                        </button>
                    </div>
                    <p class="raca_animal">Siamês</p>
                    <p class="descricao_animal">Carinhosa e crente</p>
                    <p class="idade_animal"> 1 ano </p>
                    <p class="sexo_animal">Femêa</p>

                    <button class="botao_solicitacao">Quero Adotar</button>
                </div>
            </div>


        </div>



    </div>


    <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario'): ?>
        <div class="painelOng">
            <h1>Editar dados dos animais</h1>
            <br>
            <br>
            <a href="criar.php">Adicionar animal</a>
        </div>
    <?php endif; ?>



    <div id="tela">
        <form method="POST" action="login.php">
            <div class="fazerLogin">
                <button id="sairLogin">X</button>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="password">Senha:</label>
                <input type="password" id="senha" name="senha">

                <button class="loginOK" title="loginOK">Pronto</button>
                <button type="submit" class="criar_contaTutor" title="Criar Conta">Criar conta</button>
            </div>
        </form>
        <form method="POST" action="cadastrar.php">
            <div class="criarConta">
                <button type="button" id="sairConta">X</button>

                <label for="nomeC">Nome:</label>
                <input type="text" id="nomeC" name="nomeC" required>

                <label for="cpfC">CPF:</label>
                <input type="text" id="cpfC" name="cpfC" required>

                <label for="emailC">Email:</label>
                <input type="email" id="emailC" name="emailC" required>

                <label for="contato">Contato:</label>
                <input type="text" id="contato" name="contato" required>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" required>

                <label for="senhaC">Senha:</label>
                <input type="password" class="senhaC" name="senhaC" required>

                <label for="senhaC2">Confirme sua senha:</label>
                <input type="password" class="senhaC2" name="senhaC2" required>

                <button type="submit" class="botaoConta" title="botaoConta">Criar conta</button>
            </div>
        </form>
    </div>

    <script>
        const usuarioLogado = <?php echo $logado; ?>;
        const ehFuncionario = <?php echo $ehFuncionario; ?>;
    </script>
    <script src="adocao.js"></script>

</body>

</html>