document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("btnMostrar");
    const card = document.getElementById("skills");

    if (btn && card) {
        btn.addEventListener("click", () => {
            if (card.classList.contains("show")) {
                card.classList.remove("show");
                setTimeout(() => {
                    card.style.display = "none";
                }, 500); // Espera a que termine la transición
                btn.textContent = "Mis conocimientos";
            } else {
                card.style.display = "block";
                setTimeout(() => {
                    card.classList.add("show");
                }, 10); // Pequeño delay para que la transición funcione
                btn.textContent = "Ocultar habilidades";
            }
        });
    }

    const contenedorMaterias = document.getElementById("contenedor-materias");
    if (contenedorMaterias) {
        fetch("materias.php")
            .then(response => response.text())
            .then(html => {
                contenedorMaterias.innerHTML = html;
            })
            .catch(error => {
                console.error("Error al cargar materias:", error);
                contenedorMaterias.innerHTML = "<p class='text-danger text-center'>Error al cargar las materias finalizadas.</p>";
            });
    }
    // Lógica para mostrar/ocultar columnas de edición en materias.php
    const btnEditar = document.getElementById('btn-editar');
    if (btnEditar) {
        btnEditar.addEventListener('click', function () {
            const elementosOcultos = document.querySelectorAll('.col-oculta');

            elementosOcultos.forEach(el => {
                const isTableCol = el.tagName === 'TH' || el.tagName === 'TD';
                if (el.style.display === (isTableCol ? 'table-cell' : 'flex')) {
                    el.style.display = 'none';
                } else {
                    el.style.display = isTableCol ? 'table-cell' : 'flex';
                }
            });

            this.textContent = this.textContent.trim() === 'Editar' ? 'Listo' : 'Editar';
            this.classList.toggle('btn-outline-light');
            this.classList.toggle('btn-secondary');
        });
    }

});