// Mostrar / ocultar senha
const inputSenha = document.getElementById('senha');
const btnToggleSenha = document.getElementById('toggleSenha');

if (inputSenha && btnToggleSenha) {
    btnToggleSenha.addEventListener('click', () => {
        const oculta = inputSenha.type === 'password';
        inputSenha.type = oculta ? 'text' : 'password';
        btnToggleSenha.textContent = oculta ? 'Ocultar' : 'Mostrar';
    });
}

// Revelar seções suavemente ao rolar
const elementosRevelar = document.querySelectorAll('.revelar');
const observadorEntrada = new IntersectionObserver(
    (entradas) => {
        entradas.forEach((entrada) => {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visivel');
                observadorEntrada.unobserve(entrada.target);
            }
        });
    },
    { threshold: 0.12 }
);

elementosRevelar.forEach((el) => observadorEntrada.observe(el));

// Destacar link ativo no menu conforme a seção visível
const secoes = document.querySelectorAll('section[id]');
const linksNav = document.querySelectorAll('.link-nav');

const observadorNav = new IntersectionObserver(
    (entradas) => {
        entradas.forEach((entrada) => {
            if (entrada.isIntersecting) {
                const id = entrada.target.getAttribute('id');
                linksNav.forEach((link) => {
                    link.classList.toggle('ativo', link.getAttribute('href') === `#${id}`);
                });
            }
        });
    },
    { rootMargin: '-40% 0px -50% 0px' }
);

secoes.forEach((secao) => observadorNav.observe(secao));
