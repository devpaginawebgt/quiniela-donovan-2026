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

    // ========== NOTIFICACIONES ==========
    if ($("#tabla-notificaciones").length) {
        const $tabla = $("#tabla-notificaciones");
        const showBaseUrl = $tabla.data("show-url");
        const cancelUrlTemplate = $tabla.data("cancel-url-template");

        const tablaNotificaciones = $tabla.DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: $tabla.data("url"),
            lengthChange: false,
            ordering: false,
            search: { return: true },
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
            },
            columns: [
                { data: "id", title: "#" },
                { data: "title", title: "Título" },
                { data: "audiencia", title: "Audiencia" },
                { data: "scheduled_at_formatted", title: "Programada para" },
                { data: "fecha", title: "Fecha de creación" },
                { data: "status_badge", title: "Estado", orderable: false, searchable: false },
                { data: "acciones", title: "Acciones", orderable: false, searchable: false },
            ],
        });

        const detailModalEl = document.getElementById("notification-detail-modal");
        const detailModal = detailModalEl && window.Modal ? new window.Modal(detailModalEl) : null;

        const setField = (name, value) => {
            const node = detailModalEl?.querySelector(`[data-field="${name}"]`);
            if (!node) return;
            node.textContent = value ?? "—";
        };

        const setHtmlField = (name, html) => {
            const node = detailModalEl?.querySelector(`[data-field="${name}"]`);
            if (!node) return;
            node.innerHTML = html ?? "";
        };

        const statusBadgeHtml = (status, label) => {
            const map = {
                sent:     ["bg-green-100",  "text-green-700",  "border-green-200",  "bg-green-600"],
                sending:  ["bg-blue-100",   "text-blue-700",   "border-blue-200",   "bg-blue-600"],
                pending:  ["bg-amber-100",  "text-amber-700",  "border-amber-200",  "bg-amber-500"],
                failed:   ["bg-red-100",    "text-red-700",    "border-red-200",    "bg-red-600"],
                canceled: ["bg-gray-100",   "text-gray-700",   "border-gray-200",   "bg-gray-500"],
            };
            const [bg, text, border, dot] = map[status] ?? map.canceled;
            return `
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border ${bg} ${text} ${border}">
                    <span class="w-1.5 h-1.5 rounded-full ${dot}"></span>
                    ${label ?? status}
                </span>
            `;
        };

        $tabla.on("click", ".js-notification-show", function () {
            const id = $(this).data("id");
            if (!id || !detailModal) return;

            window.axios
                .get(`${showBaseUrl}/${id}`)
                .then(({ data }) => {
                    setField("title", data.title);
                    setField("description", data.description);
                    setField("audience", data.audience);
                    setField("created_by", data.created_by);
                    setField("scheduled_at", data.scheduled_at);
                    setField("sent_at", data.sent_at);
                    setHtmlField("status_badge", statusBadgeHtml(data.status, data.status_label));

                    const img = detailModalEl.querySelector('[data-field="image"]');
                    if (img) {
                        if (data.image_url) {
                            img.src = data.image_url;
                            img.alt = data.title ?? "";
                            img.classList.remove("hidden");
                        } else {
                            img.src = "";
                            img.classList.add("hidden");
                        }
                    }

                    const commentWrapper = detailModalEl.querySelector('[data-field="comment-wrapper"]');
                    if (commentWrapper) {
                        if (data.comment) {
                            setField("comment", data.comment);
                            commentWrapper.classList.remove("hidden");
                        } else {
                            commentWrapper.classList.add("hidden");
                        }
                    }

                    detailModal.show();
                })
                .catch(() => {
                    Swal.fire("Error", "No se pudo cargar el detalle de la notificación.", "error");
                });
        });

        $tabla.on("click", ".js-notification-cancel", function () {
            if ($(this).is("[disabled]")) return;
            const id = $(this).data("id");
            if (!id) return;

            Swal.fire({
                title: "¿Cancelar el envío?",
                text: "Esta notificación pendiente quedará marcada como cancelada y no se enviará.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Sí, cancelar envío",
                cancelButtonText: "Volver",
            }).then((result) => {
                if (!result.isConfirmed) return;

                window.axios
                    .patch(cancelUrlTemplate.replace("__ID__", id))
                    .then(() => {
                        tablaNotificaciones.ajax.reload(null, false);
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: "Envío cancelado",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    })
                    .catch((error) => {
                        const message = error?.response?.data?.message ?? "No se pudo cancelar la notificación.";
                        Swal.fire("Error", message, "error");
                    });
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
