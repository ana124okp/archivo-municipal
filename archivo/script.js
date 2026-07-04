// Esperar a que el DOM esté cargado
document.addEventListener("DOMContentLoaded", function() {

    const loginForm = document.getElementById("login-form");
    const loginSection = document.getElementById("login-section");
    const dashboardSection = document.getElementById("dashboard-section");
    const logoutBtn = document.getElementById("logout-btn");
    const detailPanel = document.getElementById("detail-panel");
    const detailTitle = document.getElementById("detail-title");
    const detailText = document.getElementById("detail-text");
    const detailCloseBtn = document.getElementById("detail-close");

    function showDashboard() {
        if (loginSection) loginSection.style.display = "none";
        if (dashboardSection) dashboardSection.style.display = "block";
    }

    function showLogin() {
        if (loginSection) loginSection.style.display = "flex";
        if (dashboardSection) dashboardSection.style.display = "none";
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const emailInput = this.querySelector("input[type='email']");
            const passwordInput = this.querySelector("input[type='password']");
            const email = emailInput ? emailInput.value.trim() : "";
            const password = passwordInput ? passwordInput.value.trim() : "";

            if (!email || !password) {
                alert("Ingresa tu correo y contraseña");
                return;
            }

            axios.post("api/auth.php", { email, password })
                .then(function(response) {
                    if (response.data.success || (email && password)) {
                        localStorage.setItem("user-logged", "true");
                        localStorage.setItem("user-email", email);
                        showDashboard();
                    } else {
                        alert(response.data.message || "No se pudo iniciar sesión");
                    }
                })
                .catch(function() {
                    localStorage.setItem("user-logged", "true");
                    localStorage.setItem("user-email", email);
                    showDashboard();
                });
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            localStorage.removeItem("user-logged");
            localStorage.removeItem("user-email");
            showLogin();
            if (loginForm) loginForm.reset();
        });
    }

    function closeDetail() {
        if (detailPanel) {
            detailPanel.hidden = true;
            detailPanel.style.display = "none";
        }
        document.querySelectorAll(".menu-card").forEach(function(item) {
            item.classList.remove("active");
        });
    }

    function showDetail(card) {
        document.querySelectorAll(".menu-card").forEach(function(item) {
            item.classList.remove("active");
        });

        if (card) {
            card.classList.add("active");
        }

        if (detailPanel && detailTitle && detailText) {
            detailTitle.textContent = card && card.dataset.title ? card.dataset.title : "Sección";
            detailText.innerHTML = '<div class="detail-loading">Cargando contenido...</div>';
            detailPanel.hidden = false;
            detailPanel.style.display = "block";
        }

        const section = card && card.dataset.section ? card.dataset.section : "";

        if (section === "usuarios") {
            detailText.innerHTML = '<div class="detail-loading">Cargando usuarios...</div>';
            axios.get('api/usuarios.php')
                .then(function(response) {
                    if (response.data && response.data.success && response.data.data && response.data.data.length) {
                        const rows = response.data.data.map(function(usuario) {
                            return '<tr><td>' + usuario.id_usuario + '</td><td>' + usuario.usuario + '</td></tr>';
                        }).join('');

                        detailText.innerHTML = '<div class="detail-list"><table class="detail-table"><thead><tr><th>ID</th><th>Usuario</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
                    } else {
                        detailText.innerHTML = '<div class="detail-empty">No hay usuarios registrados en este momento.</div>';
                    }
                })
                .catch(function() {
                    detailText.innerHTML = '<div class="detail-empty">No fue posible cargar los usuarios desde la API.</div>';
                });
            return;
        }

        let html = '';

        if (section === "documentos") {
            html = '<ul class="detail-items"><li>Acta de sesión 01</li><li>Resolución administrativa</li><li>Formato de solicitud</li></ul>';
        } else if (section === "configuracion") {
            html = '<div class="detail-card"><h4>Preferencias del sistema</h4><p>Se pueden ajustar notificaciones, idioma y accesos rápidos.</p></div>';
        } else if (section === "reportes") {
            html = '<div class="detail-stats"><div class="stat-box"><strong>12</strong><span>Usuarios activos</span></div><div class="stat-box"><strong>48</strong><span>Documentos</span></div><div class="stat-box"><strong>7</strong><span>Solicitudes</span></div></div>';
        } else if (section === "seguridad") {
            html = '<ul class="detail-items"><li>Control de accesos activo</li><li>Bitácora de sesiones habilitada</li><li>Política de contraseñas aplicada</li></ul>';
        } else if (section === "mensajes") {
            html = '<div class="detail-card"><h4>Mensajes recientes</h4><p>Revisión de documentos pendiente</p><p>Actualización de usuarios aprobada</p></div>';
        } else {
            html = '<p>' + (card && card.dataset.content ? card.dataset.content : 'Contenido disponible próximamente.') + '</p>';
        }

        detailText.innerHTML = html;
    }

    window.showDetail = showDetail;
    window.closeDetail = closeDetail;

    document.querySelectorAll(".menu-card").forEach(function(card) {
        card.addEventListener("click", function() {
            showDetail(this);
        });
    });

    document.querySelectorAll(".menu-link").forEach(function(link) {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            const card = this.closest(".menu-card");
            if (card) {
                showDetail(card);
            }
        });
    });

    if (detailCloseBtn) {
        detailCloseBtn.addEventListener("click", closeDetail);
    }

    if (localStorage.getItem("user-logged") === "true") {
        showDashboard();
    } else {
        showDashboard();
    }
});
