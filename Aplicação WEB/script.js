document.addEventListener('DOMContentLoaded', () => {
    const favoriteButtons = document.querySelectorAll('.favorite-button');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.classList.toggle('active'); // Alterna a classe para alterar a cor
        });
    });
});
