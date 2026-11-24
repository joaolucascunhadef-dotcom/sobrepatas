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
        botaoLogin.style.display = "none";

    });
    if (pronto) {
        botaoLogin.addEventListener('click', function () {

            const senhaL1 = document.getElementById('senha').value;
            const emailL1 = document.getElementById('email').value;
            if (senhaL1 != "" && emailL1 != "") {
                alert('Conta conectada com sucesso!');
                botaoLogin.style.display = "none";
                logout.style.display = "block";
                logout.style.display = "block";


                divCriarConta.style.display = "none";
                tela.style.display = "none";

            } else {
                alert('Usuário não encontrado');
            }

        }
        )
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
        if (senha1 === senha2 && senha1 != "") {
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


//Deslogar
if (logout) {

    logout.addEventListener('click', function () {
        logout.style.display = "none";
        botaoLogin.style.display = "block";

    }

    )
}



// Barra de pesquisa
const inputPesquisa = document.getElementById('pesquisa');
const cardsAnimais = document.querySelectorAll('.aba_animal');

if (inputPesquisa) {
    inputPesquisa.addEventListener('input', (e) => {
        const termo = e.target.value.toLowerCase();

        cardsAnimais.forEach(card => {
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


//Favoritar animal
const botaoFav = document.querySelectorAll('.botao_favorito');

botaoFav.forEach(function (botaoFav) {
    botaoFav.addEventListener('click', function () {
        const img = botaoFav.querySelector('img');
        if (!img) return;

        // Alterna entre estrela.png e estrelaFav.png
        if (img.getAttribute('src') === 'estrela.png') {
            img.setAttribute('src', 'estrelaFav.png');
            botao.title = 'Desfavoritar';
        } else {
            img.setAttribute('src', 'estrela.png');
            botao.title = 'Favoritar';
        }
    });
});

// Filtrar por raça, nome ou tipo
const botoesFiltro = document.querySelectorAll('.tipos');

botoesFiltro.forEach(botao => {
    botao.addEventListener('click', () => {
        const categoria = botao.textContent.trim().toLowerCase();

        cardsAnimais.forEach(card => {
            const tipoCard = card.getAttribute('data-tipo'); // 'cao' ou 'gato'

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



// Solicitar Adoção
document.querySelectorAll('.botao_solicitacao').forEach(botao => {
    botao.addEventListener('click', () => {
        alert("Solicitação de adoção enviada com sucesso! A ONG entrará em contato.");
    });
});
