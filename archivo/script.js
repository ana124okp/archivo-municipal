// Esperar a que el DOM esté cargado
document.addEventListener("DOMContentLoaded", function() {
    
    // Manejar el login
    const loginForm = document.getElementById("login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Obtener valores del formulario
            const email = this.querySelector("input[type='email']").value;
            const password = this.querySelector("input[type='password']").value;
            
            // Validación simple
            if (email && password) {
                // Ocultar sección de login
                document.getElementById("login-section").style.display = "none";
                
                // Mostrar dashboard
                document.getElementById("dashboard-section").style.display = "block";
                
                // Guardar sesión en localStorage
                localStorage.setItem("user-logged", "true");
                localStorage.setItem("user-email", email);
            }
        });
    }

    // Manejar logout
    const logoutBtn = document.getElementById("logout-btn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            // Mostrar sección de login
            document.getElementById("login-section").style.display = "flex";
            
            // Ocultar dashboard
            document.getElementById("dashboard-section").style.display = "none";
            
            // Limpiar localStorage
            localStorage.removeItem("user-logged");
            localStorage.removeItem("user-email");
            
            // Limpiar formulario
            document.getElementById("login-form").reset();
        });
    }

    // Verificar si ya hay sesión iniciada
    if (localStorage.getItem("user-logged") === "true") {
        document.getElementById("login-section").style.display = "none";
        document.getElementById("dashboard-section").style.display = "block";
    }
});
