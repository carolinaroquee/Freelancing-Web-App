function toggleProfileMenu() {
    const menu = document.getElementById('profile-menu');
    // Alterna entre mostrar e esconder o menu
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Fecha o menu quando clicar fora dele
document.addEventListener('click', function(event) {
    const menu = document.getElementById('profile-menu');
    const profileButton = document.querySelector('.profile-button');
    
    // Se o clique não for no menu ou no botão de perfil, fecha o menu
    if (!menu.contains(event.target) && !profileButton.contains(event.target)) {
        menu.style.display = 'none';
    }
});

