<?php
session_start();
include 'conexao.php';

$logado = isset($_SESSION['email']) ? 'true' : 'false';
$ehFuncionario = (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario') ? 'true' : 'false';


$sql = "SELECT a.*, t.nome AS tipo_nome
        FROM animal a
        LEFT JOIN tipo_animal t ON a.tipo_animal_id = t.id
        ORDER BY a.id DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Patas - Adoção de Animais</title>
    <link rel="stylesheet" href="index.css">


</head>

<body>

    <div class="pagina">
        <header class="banner">
            <div class="login_area">
                <img class="pata" src="pata.png" alt="Logo pata">
                <h1 class="titulo">Sobre patas</h1>
            </div>

            <?php if (isset($_SESSION['email'])): ?>
                <a href="logout.php" id="sair" class="sair">Sair</a>
            <?php else: ?>
                <a href="login.php" id="login" class="login">Login</a>
            <?php endif; ?>

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

        <?php
        while ($animal = mysqli_fetch_assoc($resultado)) {
            ?>

            <div class="aba_animal" data-tipo="<?php echo $animal['tipo_nome'] == 'Gato' ? 'gato' : 'cao'; ?>">

                <?php
                if ($ehFuncionario == 'true') {
                    ?>
                    <a href="excluir.php?id=<?php echo $animal['id']; ?>" class="botao_excluir" title="Excluir">
                        X
                    </a>
                    <?php
                }
                ?>

                <img class="foto_animal" src="<?php echo $animal['foto']; ?>" alt="Foto do animal">

                <div class="info_animal">

                    <div class="info_aba">
                        <h3 class="nome_animal"><?php echo $animal['nome']; ?></h3>

                        <button class="botao_favorito" id="fav_<?php echo $animal['id'];  ?>" title="Favoritar">
                            <img src="estrela.png" alt="Favoritar">
                        </button>
                    </div>

                    <p class="raca_animal"><?php echo $animal['raca']; ?></p>
                    <p class="descricao_animal"><?php echo $animal['descricao']; ?></p>
                    <p class="idade_animal"><?php echo $animal['idade']; ?></p>
                    <p class="sexo_animal"><?php echo $animal['sexo']; ?></p>

                    <button class="botao_solicitacao">Quero Adotar</button>

                </div>
            </div>

            <?php
        }
        ?>


        <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'funcionario'): ?>
            <div class="painelOng">
                <h1>Editar dados dos animais</h1>
                <br>
                <br>
                <div class="opcONG">
                <a href="criar.php">Adicionar animais</a>
                
                <a href="lista.php">Listar animais</a>

                <a href="editar.php">Editar dados dos animais</a>
                </div>
            </div>
        <?php endif; ?>



        <div id="tela">
            <form id="formLogin" method="POST" action="login.php">
                <div class="fazerLogin">
                    <button id="sairLogin">X</button>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">

                    <label for="password">Senha:</label>
                    <input type="password" id="senha" name="senha">

                    <button class="loginOK" title="loginOK" name="loginOK">Pronto</button>
                    <button type="submit" class="criar_contaTutor" name="loginOK" title="Criar Conta">Criar
                        conta</button>
                    <p id="mensagem"></p>
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
                    <p id="mensagemCadastro"></p>
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