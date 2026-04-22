$(function () {
    // ========== PRONOSTICOS ==========
    if ($("#tabla-pronosticos").length) {
        const tablaPronosticos = $("#tabla-pronosticos").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: $("#tabla-pronosticos").data("url"),
            lengthChange: false,
            ordering: false,
            search: { return: true },
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
            },
            columns: [
                { data: "id", title: "#" },
                { data: "usuario", title: "Usuario" },
                { data: "email", title: "Correo Electrónico" },
                { data: "numero_documento", title: "No. Documento" },
                { data: "telefono", title: "Teléfono" },
                { data: "direccion", title: "Dirección", orderable: false, searchable: false },
                { data: "colegiado", title: "Colegiado" },
                { data: "pais", title: "País" },
                { data: "tipo", title: "Tipo" },
                { data: "cadena", title: "Cadena" },
                { data: "visitador", title: "Visitador" },
                { data: "region", title: "Región" },
                { data: "capital", title: "Capital", orderable: false, searchable: false },
                { data: "farmacia", title: "Farmacia", orderable: false, searchable: false },
                { data: "partido", title: "Partido", orderable: false },
                { data: "jornada", title: "Jornada" },
                { data: "fecha_partido", title: "Fecha Partido" },
                { data: "fecha_registro", title: "Fecha Registro" },
                { data: "fecha_actualizacion", title: "Última Actualización" },
                { data: "pronostico", title: "Pronóstico", orderable: false, searchable: false },
                {
                    data: "resultado_real",
                    title: "Resultado Real",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "puntos_badge",
                    title: "Puntos",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "estado_badge",
                    title: "Estado",
                    orderable: false,
                    searchable: false,
                },
            ],
        });

        $("#form-export-predictions").on("submit", function (e) {
            e.preventDefault();

            const btn = $("#btn-export-predictions");
            const text = $("#btn-export-predictions-text");

            btn.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");
            text.text("Generando Excel...");

            $.ajax({
                url: $(this).attr("action"),
                method: "GET",
                xhrFields: { responseType: "blob" },
                data: { search: tablaPronosticos.search() },
                success: function (data, status, xhr) {
                    const url = window.URL.createObjectURL(new Blob([data]));
                    const disposition = xhr.getResponseHeader("content-disposition");
                    let fileName = "pronosticos.xlsx";

                    if (disposition) {
                        const match = disposition.match(/filename="?(.+)"?/);
                        if (match && match[1]) fileName = match[1];
                    }

                    $("<a>").attr({ href: url, download: fileName })[0].click();
                    window.URL.revokeObjectURL(url);
                },
                error: function () {
                    Swal.fire("Error", "No se pudo exportar el archivo.", "error");
                },
                complete: function () {
                    btn.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");
                    text.text("Descargar Excel");
                },
            });
        });
    }

    // ========== USUARIOS ==========
    if (!$("#tabla-usuarios").length) return;
    const tablaUsuarios = $("#tabla-usuarios").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: $("#tabla-usuarios").data("url"),
        lengthChange: false,
        ordering: false,
        search: { return: true },
        language: {
            url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
        },
        columns: [
            { data: "id", title: "#" },
            { data: "nombre_completo", title: "Usuario" },
            { data: "numero_documento", title: "No. Documento" },
            { data: "email", title: "Correo Electrónico" },
            { data: "telefono", title: "Teléfono" },
            { data: "direccion", title: "Dirección", orderable: false, searchable: false },
            { data: "colegiado", title: "Colegiado" },
            { data: "pais", title: "País" },
            { data: "tipo", title: "Tipo" },
            { data: "cadena", title: "Cadena" },
            { data: "visitador", title: "Visitador" },
            { data: "region", title: "Región" },
            { data: "capital", title: "Capital", orderable: false, searchable: false },
            { data: "farmacia", title: "Farmacia", orderable: false, searchable: false },
            { data: "puntos_trivias", title: "Puntos Trivias" },
            { data: "puntos_predicciones", title: "Puntos Predicciones" },
            { data: "puntos_bonus", title: "Puntos Bonus" },
            { data: "puntos", title: "Puntos Total" },
            { data: "fecha_registro", title: "Fecha Registro" },
            {
                data: "estado_badge",
                title: "Estado",
                orderable: false,
                searchable: false,
            },
            {
                data: "notificaciones_badge",
                title: "Notificaciones",
                orderable: false,
                searchable: false,
            },
        ],
    });

    $("#form-export").on("submit", function (e) {
        e.preventDefault();

        const btn = $("#btn-export");
        const text = $("#btn-export-text");

        btn.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");
        text.text("Generando Excel...");

        $.ajax({
            url: $(this).attr("action"),
            method: "GET",
            xhrFields: { responseType: "blob" },
            data: { search: tablaUsuarios.search() },
            success: function (data, status, xhr) {
                const url = window.URL.createObjectURL(new Blob([data]));
                const disposition = xhr.getResponseHeader(
                    "content-disposition",
                );
                let fileName = "usuarios.xlsx";

                if (disposition) {
                    const match = disposition.match(/filename="?(.+)"?/);
                    if (match && match[1]) fileName = match[1];
                }

                $("<a>").attr({ href: url, download: fileName })[0].click();
                window.URL.revokeObjectURL(url);
            },
            error: function () {
                Swal.fire("Error", "No se pudo exportar el archivo.", "error");
            },
            complete: function () {
                btn.prop("disabled", false).removeClass(
                    "opacity-50 cursor-not-allowed",
                );
                text.text("Exportar Excel");
            },
        });
    });
});
