document.addEventListener('DOMContentLoaded', () => {
    
    const inputCalendario = document.getElementById('jornadas');
    if (!inputCalendario) return;

    verPartidosJornada(inputCalendario.value);

    inputCalendario.addEventListener('change', function () {
        if (!this.value) return;
        verPartidosJornada(this.value);
    });

    const buscar = document.getElementById('buscar-partidos');
    if (buscar) {
        buscar.addEventListener('input', function () {
            filtrarMatchCards(this.value);
        });
    }
});
