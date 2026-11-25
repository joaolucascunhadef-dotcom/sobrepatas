// Login
const botaoLogin = document.querySelector('.login');
const divLogin = document.querySelector('.fazerLogin');
const tela = document.getElementById('tela');
const sairLogin = document.getElementById('sairLogin');
const logout = document.querySelector('.sair');
const pronto = document.querySelector('.loginOK');

if (botaoLogin) {
    botaoLogin.addEventListener('click', function () {
        tela.style.display = "block";
        divLogin.style.display = "block";
    });

    if (pronto) {
        pronto.addEventListener('click', function () {
            const senhaL1 = document.getElementById('password').value;
            const emailL1 = document.getElementById('email').value;
            if (senhaL1 !== "" && emailL1 !== "") {
                alert('Conta conectada com sucesso!');
                botaoLogin.style.display = "none";
                logout.style.display = "block";
                divCriarConta.style.display = "none";
                tela.style.display = "none";
            } else {
                alert('Usuário não encontrado');
            }
        });
    }
}

if (sairLogin) {
    sairLogin.addEventListener('click', function () {
        tela.style.display = "none";
        divLogin.style.display = "none";
    });
}

// Criar conta
const botaoAbrirConta = document.querySelector('.criar_contaTutor');
const sairConta = document.getElementById('sairConta');
const divCriarConta = document.querySelector('.criarConta');
const botaoFinalCriarConta = document.querySelector('.botaoConta');

if (botaoAbrirConta) {
    botaoAbrirConta.addEventListener('click', function () {
        divCriarConta.style.display = "block";
        divLogin.style.display = "none";
        tela.style.display = "block";
    });
}

if (sairConta) {
    sairConta.addEventListener('click', function () {
        tela.style.display = "none";
        divCriarConta.style.display = "none";
    });
}

if (botaoFinalCriarConta) {
    botaoFinalCriarConta.addEventListener('click', function () {
        const senha1 = document.querySelector('.senhaC').value;
        const senha2 = document.querySelector('.senhaC2').value;
        if (senha1 === senha2 && senha1 !== "") {
            alert('Conta criada com sucesso!');
            botaoLogin.style.display = "none";
            logout.style.display = "block";
            divCriarConta.style.display = "none";
            tela.style.display = "none";
        } else {
            alert('Digite a mesma senha nos dois campos');
        }
    });
}

// Deslogar
if (logout) {
    logout.addEventListener('click', function () {
        logout.style.display = "none";
        botaoLogin.style.display = "block";
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

                const card = document.createElement('div');
                card.className = 'aba_animal';
                card.setAttribute('data-tipo', tipo);
                card.setAttribute('data-id', id);

                card.innerHTML = `
                    <button class="botao_excluir" title="Excluir">&times;</button>
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


    // favoritar e solicitar adoção 
    gradeAnimais.addEventListener('click', (evento) => {
        const botaoFav = evento.target.closest('.botao_favorito');
        if (botaoFav) {
            const img = botaoFav.querySelector('img');
            if (!img) return;

            const botoes = Array.from(document.querySelectorAll('.botao_favorito'));
            const indice = botoes.indexOf(botaoFav);

            if (img.getAttribute('src') === 'estrela.png') {
                img.setAttribute('src', 'estrelaFav.png');
                botaoFav.title = 'Desfavoritar';
                localStorage.setItem('favorito_' + indice, 'true');
            } else {
                img.setAttribute('src', 'estrela.png');
                botaoFav.title = 'Favoritar';
                localStorage.removeItem('favorito_' + indice);
            }
            return;
        }

        const botaoAdotar = evento.target.closest('.botao_solicitacao');
        if (botaoAdotar) {
            alert('Solicitação de adoção enviada com sucesso! A ONG entrará em contato.');
        }
    });


    //guardar animais favoritos ao recarregar a pagina
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

}


// Barra de pesquisa (busca sempre todos os cards
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

