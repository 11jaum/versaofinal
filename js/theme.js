document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('toggleThemeBtn');
    
    // Verificar se o tema foi salvo no localStorage
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark');
        toggleButton.classList.add('dark');
        toggleButton.textContent = 'Ativar Tema Claro'; // Mudança no texto do botão
    } else {
        document.body.classList.remove('dark');
        toggleButton.classList.remove('dark');
        toggleButton.textContent = 'Ativar Tema Escuro'; // Mudança no texto do botão
    }

    // Alternar o tema ao clicar no botão
    toggleButton.addEventListener('click', () => {
        if (document.body.classList.contains('dark')) {
            document.body.classList.remove('dark');
            toggleButton.classList.remove('dark');
            toggleButton.textContent = 'Ativar Tema Escuro';
            localStorage.setItem('theme', 'light'); // Salvar a preferência
        } else {
            document.body.classList.add('dark');
            toggleButton.classList.add('dark');
            toggleButton.textContent = 'Ativar Tema Claro';
            localStorage.setItem('theme', 'dark'); // Salvar a preferência
        }
    });
});
