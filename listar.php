<?php
    session_start();
    include('conexao.php');

    $busca = isset($_GET['busca']) ? mysqli_real_escape_string($conexao, trim($_GET['busca'])) : '';

    //sql para pesquisar no banco
    $sql = "SELECT a.id, a.nome, a.raca, a.idade, a.sexo, a.foto, a.descricao, t.nome AS tipo_nome
            FROM animal a
            LEFT JOIN tipo_animal t ON a.tipo_animal_id = t.id
            WHERE a.nome LIKE '%" . $busca . "%'
               OR a.raca LIKE '%" . $busca . "%'
            ORDER BY a.nome ASC";

    $animal = mysqli_query($conexao, $sql);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap">
    <title>SobrePatas - Lista de Animais</title>
    <link rel="stylesheet" href="criar.css">
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
            <h1 class="error-title">Lista de animais</h1>
            <div class="error-description">
                <div style="text-align: left;">
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
                </div>
                <p><a href="criar.php"><button type="button" class="btn btn--primary">Adicionar animal</button></a></p>
                <p>
                    <table class="table table-striped table-hover" style="text-align: left;">
                        <thead>
                            <tr>
                                <form action="listar.php" method="GET">
                                    <th colspan="3">
                                        <input type="text" name="busca" class="input" placeholder="Digite algo..." value="<?php echo $busca; ?>" autofocus>
                                    </th>
                                    <th width="50">
                                        <button type="submit" id="btn-pesquisa" class="btn btn--secondary">Pesquisar</button>
                                    </th>
                                </form>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Raça</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($animal && mysqli_num_rows($animal) > 0) {
                                    // imprime os resultados na tela
                                    $resp = '';
                                    while($tupla = mysqli_fetch_assoc($animal)) {
                                        $resp = '<tr>';
                                        $resp .= '<td>'.$tupla["id"].'</td>';
                                        $resp .= '<td>'.$tupla["nome"].'</td>';
                                        $resp .= '<td>'.$tupla["raca"].'</td>';
                                        $resp .= '<td>
                                                    <a href="editar.php?id='.$tupla["id"].'"><button class="btn btn--secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/></svg></button></a>
                                                    <a href="excluir.php?id='.$tupla["id"].'"><button class="btn btn--secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2-fill" viewBox="0 0 16 16"><path d="M2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z"/></svg></button></a>
                                                </td>';
                                        $resp .= '</tr>';
                                        echo $resp;
                                        $resp = '';
                                    }
                                } else {
                                    $resp = '<tr>';
                                    $resp .= '<td colspan="4">Nenhum animal encontrado</td>';
                                    $resp .= '</tr>';
                                    echo $resp;
                                }

                                mysqli_close($conexao);
                            ?>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
    </div>
</body>

</html>