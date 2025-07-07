// Funcionalidad para alternar entre login y registro con animación
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    // Función para mostrar el formulario de registro
    if (registerBtn) {
        registerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (container) {
                container.classList.add('active');
            }
        });
    }

    // Función para mostrar el formulario de login
    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (container) {
                container.classList.remove('active');
            }
        });
    }

    // Detectar si hay errores de validación para mostrar el formulario correcto
    const loginErrors = document.querySelector('.form-box.login .error-message');
    const registerErrors = document.querySelector('.form-box.register .error-message');
    
    // Si hay errores en el registro, mostrar el formulario de registro
    if (registerErrors && container) {
        container.classList.add('active');
    }
    
    // Si hay errores en el login, asegurarse de mostrar el formulario de login
    if (loginErrors && container) {
        container.classList.remove('active');
    }
});