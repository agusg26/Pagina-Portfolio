document.addEventListener("DOMContentLoaded", () => {
    // Mostrar/Ocultar habilidades
    const btn = document.getElementById("btnMostrar");
    const card = document.getElementById("skills");

    if (btn && card) {
        btn.addEventListener("click", () => {
            if (card.classList.contains("show")) {
                card.classList.remove("show");
                setTimeout(() => {
                    card.style.display = "none";
                }, 500);
                btn.textContent = "Mis conocimientos";
            } else {
                card.style.display = "block";
                setTimeout(() => {
                    card.classList.add("show");
                }, 10);
                btn.textContent = "Ocultar habilidades";
            }
        });
    }

    // Carga dinámica de materias
    const contenedorMaterias = document.getElementById("contenedor-materias");
    if (contenedorMaterias) {
        const materiasUrl = window.location.pathname.includes('/views/') ? 'materias.php' : 'views/materias.php';
        fetch(materiasUrl + "?t=" + Date.now(), { cache: "no-store" })
            .then(response => response.text())
            .then(html => {
                contenedorMaterias.innerHTML = html;
            })
            .catch(error => {
                console.error("Error al cargar materias:", error);
                contenedorMaterias.innerHTML = "<p class='text-danger text-center'>Error al cargar las materias finalizadas.</p>";
            });
    }

    document.addEventListener("click", (e) => {
        //Boton eliminar
        const btnEliminar = e.target.closest(".btn-eliminar");
        if (btnEliminar) {
            const confirmacion = confirm("¿Estas seguro de que deseas eliminar esta materia?");
            if (!confirmacion) {
                e.preventDefault();
            }
            return;
        }
        // Botón Editar
        const btnEditar = e.target.closest("#btn-editar");
        if (btnEditar) {
            const contenedorTabla = btnEditar.closest("#contenedor-tabla-materias") || btnEditar.closest(".table-responsive") || document;
            const estaEditando = btnEditar.getAttribute("data-editando") === "true";

            if (!estaEditando) {
                btnEditar.setAttribute("data-editando", "true");
                btnEditar.innerHTML = '<i class="bi bi-check-lg me-1"></i>Listo';
                btnEditar.classList.remove("btn-outline-dark", "btn-outline-light");
                btnEditar.classList.add("btn-secondary");
                if (contenedorTabla.classList) {
                    contenedorTabla.classList.add("modo-edicion");
                }
            } else {

                btnEditar.setAttribute("data-editando", "false");
                btnEditar.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Editar';
                btnEditar.classList.remove("btn-secondary");
                btnEditar.classList.add("btn-outline-dark");
                if (contenedorTabla.classList) {
                    contenedorTabla.classList.remove("modo-edicion");
                }
            }

            const elementosOcultos = contenedorTabla.querySelectorAll(".col-oculta");
            elementosOcultos.forEach(el => {
                const isTableCol = el.tagName === "TH" || el.tagName === "TD";
                if (!estaEditando) {
                    el.style.display = isTableCol ? "table-cell" : "inline-flex";
                } else {
                    el.style.display = "none";
                }
            });

            return;
        }

        // Botón Abrir Modal Agregar Materia (#btn-abrir-modal)
        const btnAbrirModal = e.target.closest("#btn-abrir-modal");
        if (btnAbrirModal) {
            const modal = document.getElementById("modal-agregar-materia");
            if (modal) {
                modal.classList.add("active");
            }
            return;
        }

        // Botón Cerrar Modal (#btn-cerrar-modal o #btn-cancelar-modal)
        const btnCerrarModal = e.target.closest("#btn-cerrar-modal, #btn-cancelar-modal");
        if (btnCerrarModal) {
            const modal = document.getElementById("modal-agregar-materia");
            if (modal) {
                modal.classList.remove("active");
            }
            return;
        }

        // Cerrar modal al hacer clic en el fondo oscurecido
        const modalOverlay = document.getElementById("modal-agregar-materia");
        if (modalOverlay && e.target === modalOverlay) {
            modalOverlay.classList.remove("active");
        }
    });

});