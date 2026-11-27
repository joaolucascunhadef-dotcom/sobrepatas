// Função para abrir a tela de login diretamente
function abrirTelaLogin() {
    const divLogin = document.querySelector('.fazerLogin');
    const tela = document.getElementById('tela');
    if (tela && divLogin) {
        tela.style.display = "block";
        divLogin.style.display = "block";
    }
}

// Configuração inicial do Login
function configurarLogin() {
    const botaoLogin = document.querySelector('.login');
    const divLogin = document.querySelector('.fazerLogin');
    const tela = document.getElementById('tela');
    const sairLogin = document.getElementById('sairLogin');

    if (botaoLogin) {
        botaoLogin.addEventListener('click', function (e) {
            e.preventDefault(); // 
            if (tela) {
                tela.style.display = "flex"; // 
                divLogin.style.display = "block";
            }
        });
    }

    if (sairLogin) {
        sairLogin.addEventListener('click', function (e) {
            e.preventDefault();
            if (tela) {
                tela.style.display = "none"; // Esconde o modal
            }
        });
    }
}
configurarLogin();

// Criar conta
const botaoAbrirConta = document.querySelector('.criar_contaTutor');
const sairConta = document.getElementById('sairConta');
const divCriarConta = document.querySelector('.criarConta');
const botaoFinalCriarConta = document.querySelector('.botaoConta');

if (botaoAbrirConta) {
    botaoAbrirConta.addEventListener('click', function (e) {
        e.preventDefault();
        if (divCriarConta) divCriarConta.style.display = "block";
        const divLogin = document.querySelector('.fazerLogin');
        if (divLogin) divLogin.style.display = "none";
        const tela = document.getElementById('tela');
        if (tela) tela.style.display = "block";
    });
}

if (sairConta) {
    sairConta.addEventListener('click', function () {
        const tela = document.getElementById('tela');
        if (tela) tela.style.display = "none";
        if (divCriarConta) divCriarConta.style.display = "none";
    });
}



// Carregar animais do banco (via listar.php) junto com os cards do index.html
const gradeAnimais = document.querySelector('.imagens_animais');

if (gradeAnimais) {
    fetch('listar.php')
        .then((resposta) => resposta.text())
        .then((html) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const linhas = doc.querySelectorAll('table tbody tr');

            linhas.forEach((linha) => {
                const colunas = linha.querySelectorAll('td');
                if (colunas.length < 3) return;

                const id = colunas[0].textContent.trim();
                const nome = colunas[1].textContent.trim();
                const raca = colunas[2].textContent.trim();
                const descricao = colunas[3].textContent.trim();
                const idade = colunas[4].textContent.trim();
                const sexo = colunas[5].textContent.trim();

                if (!nome || nome === 'Nenhum animal encontrado') return;

                const tipo = linha.getAttribute('data-tipo') || 'cao';
                let foto = (linha.getAttribute('data-foto') || '').trim();

                if (!foto || foto.includes(':\\') || foto.includes('C:')) {
                    foto = tipo === 'gato' ? 'gato.png' : 'cachorro.png';
                }

                // Cria o botão de excluir dinamicamente se for funcionário
                const botaoExcluirHTML = (typeof ehFuncionario !== 'undefined' && ehFuncionario)
                    ? `<button class="botao_excluir" title="Excluir">&times;</button>`
                    : '';

                const card = document.createElement('div');
                card.className = 'aba_animal';
                card.setAttribute('data-tipo', tipo);
                card.setAttribute('data-id', id);

                card.innerHTML = `
                    ${botaoExcluirHTML}
                    <img class="foto_animal" src="${foto}" alt="Foto de ${nome}">
                    <div class="info_animal">
                        <div class="info_aba">
                            <h3 class="nome_animal">${nome}</h3>
                            <button class="botao_favorito" title="Favoritar">
                                <img src="estrela.png" alt="Favoritar">
                            </button>
                        </div>
                        <p class="raca_animal">${raca}</p>
                        <p class="descricao_animal">${descricao}</p>
                        <p class="idade_animal">${idade}</p>
                        <p class="sexo_animal">${sexo}</p>
                        <button class="botao_solicitacao">Quero Adotar</button>
                    </div>
                `;

                gradeAnimais.appendChild(card);
            });
        })
        .catch((erro) => {
            console.error('Erro ao carregar animais para o index:', erro);
        });

    // Favoritar e solicitar adoção 
    gradeAnimais.addEventListener('click', function (evento) {

        if (evento.target.classList.contains('botao_favorito')) {
            const botao = evento.target;
            const imagem = botao.querySelector('img');

            if (imagem.src.includes('estrela.png')) {
                imagem.src = 'estrelaFav.png';
            } else {
                imagem.src = 'estrela.png';
            }
        }

        if (evento.target.tagName === 'IMG' && evento.target.parentElement.classList.contains('botao_favorito')) {
            const imagem = evento.target;

            if (imagem.src.includes('estrela.png')) {
                imagem.src = 'estrelaFav.png';
            } else {
                imagem.src = 'estrela.png';
            }
        }

    });

    const botaoAdotar = evento.target.closest('.botao_solicitacao');
    if (botaoAdotar) {
        if (typeof usuarioLogado !== 'undefined' && usuarioLogado) {
            alert('Solicitação de adoção enviada com sucesso! A ONG entrará em contato.');
        } else {
            alert('Você precisa fazer login para solicitar a adoção!');
            abrirTelaLogin();
        }
        return;
    }
};


// Guardar animais favoritos ao recarregar a pagina
const botoesFav = document.querySelectorAll('.botao_favorito');
for (let i = 0; i < localStorage.length; i++) {
    const chave = localStorage.key(i);
    if (chave.startsWith('favorito_')) {
        const indice = chave.replace('favorito_', '');
        const botaoFav = botoesFav[indice];
        if (botaoFav) {
            const img = botaoFav.querySelector('img');
            if (img) img.setAttribute('src', 'estrelaFav.png');
            botaoFav.title = 'Desfavoritar';
        }
    }
}

// Barra de pesquisa
const inputPesquisa = document.getElementById('pesquisa');
if (inputPesquisa) {
    inputPesquisa.addEventListener('input', (e) => {
        const termo = e.target.value.toLowerCase();
        const todosCards = document.querySelectorAll('.aba_animal');

        todosCards.forEach((card) => {
            const nome = card.querySelector('.nome_animal').textContent.toLowerCase();
            const raca = card.querySelector('.raca_animal').textContent.toLowerCase();

            if (nome.includes(termo) || raca.includes(termo)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
}
// Ajusta automaticamente os botões com base na sessão ativa
document.addEventListener("DOMContentLoaded", function () {
    const botaoSair = document.getElementById('botaoSair');
    const botaoLogin = document.getElementById('botaoLogin');

    if (typeof usuarioLogado !== 'undefined' && usuarioLogado === true) {
        if (botaoSair) botaoSair.style.display = "inline-block";
        if (botaoLogin) botaoLogin.style.display = "none";
    } else {
        if (botaoSair) botaoSair.style.display = "none";
        if (botaoLogin) botaoLogin.style.display = "inline-block";
    }
});
// Filtrar por tipo (Todos, Gatos, Cães)
const botoesFiltro = document.querySelectorAll('.tipos');
botoesFiltro.forEach((botao) => {
    botao.addEventListener('click', () => {
        const categoria = botao.textContent.trim().toLowerCase();
        const todosCards = document.querySelectorAll('.aba_animal');

        todosCards.forEach((card) => {
            const tipoCard = card.getAttribute('data-tipo');

            if (categoria === 'todos') {
                card.style.display = 'flex';
            } else if (categoria === 'gatos' && tipoCard === 'gato') {
                card.style.display = 'flex';
            } else if (categoria === 'cães' && tipoCard === 'cao') {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

//mensagem de sucesso e erro
const formLogin = document.getElementById('formLogin');
const mensagem = document.getElementById('mensagem');

formLogin.addEventListener('submit', function (event) {

    event.preventDefault();

    const dados = new FormData(formLogin);

    fetch('login.php', {
        method: 'POST',
        body: dados
    })

        .then(resposta => resposta.text())

        .then(resultado => {

            if (resultado.trim() === "sucesso") {

                mensagem.className = "sucesso";
                mensagem.innerHTML = "Login realizado com sucesso!";

                setTimeout(function () {
                    window.location.reload();
                }, 1000);


                divLogin.classList.remove('ativo');
                tela.style.display = "none";

            } else {

                mensagem.className = "erro";
                mensagem.innerHTML = resultado;

            }

        });

});