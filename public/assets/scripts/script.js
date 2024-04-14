// Função para atualizar o favicon com base no tema preferido do usuário
function atualizarFaviconComTema() {
    const faviconSite = document.querySelector('#favicon-site');

    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        // Usuário prefere tema escuro
        faviconSite.href = 'assets/img/small/ico-dark-theme.png';
    } else {
        // Usuário prefere tema claro ou tema não detectado
        faviconSite.href = 'assets/img/small/ico-light-theme.png';
    }
}

// Adiciona um observador para detectar alterações no tema preferido do usuário
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').addEventListener) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
        atualizarFaviconComTema();
    });
}

// Atualiza o favicon assim que o DOM for carregado
document.addEventListener('DOMContentLoaded', function () {
    atualizarFaviconComTema();
});
