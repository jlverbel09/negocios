document.getElementById('btnFullscreen').addEventListener('click', function (e) {
    e.preventDefault();

    const iconMax = document.getElementById('icon-maximize');
    const iconMin = document.getElementById('icon-minimize');

    if (!document.fullscreenElement) {
        // Entrar en pantalla completa
        document.documentElement.requestFullscreen().then(() => {
            iconMax.style.display = 'none';
            iconMin.style.display = 'inline-block';
        }).catch(err => {
            console.error(`Error al intentar entrar en fullscreen: ${err.message}`);
        });
    } else {
        // Salir de pantalla completa
        document.exitFullscreen();
        iconMax.style.display = 'inline-block';
        iconMin.style.display = 'none';
    }
});

// Escuchar cambios (por si el usuario presiona ESC)
document.addEventListener('fullscreenchange', () => {
    const iconMax = document.getElementById('icon-maximize');
    const iconMin = document.getElementById('icon-minimize');

    if (!document.fullscreenElement) {
        iconMax.style.display = 'inline-block';
        iconMin.style.display = 'none';
    }
});