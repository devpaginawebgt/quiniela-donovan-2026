document.addEventListener('DOMContentLoaded', () => {
    const buscar = document.getElementById('buscar-partidos');
    const lista  = document.getElementById('partidos-jornada-general');
    if (!buscar || !lista || !document.getElementById('select-mis-predicciones')) return;

    buscar.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        lista.querySelectorAll('li[data-equipos]').forEach(card => {
            card.style.display = (card.dataset.equipos ?? '').includes(term) ? '' : 'none';
        });
    });
});
