document.addEventListener( 'DOMContentLoaded' , function() {
    eventListeners();

    darkmode();

})

function darkmode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    const darkModeMensaje = document.querySelector('.dark-mode-mensaje');
    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
        darkModeMensaje.classList.add('mostrar');
    } else {
        document.body.classList.remove('dark-mode');
        darkModeMensaje.classList.remove('mostrar');
    }
    
    prefiereDarkMode.addEventListener('change', function () {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
            darkModeMensaje.classList.add('mostrar');
        } else {
            document.body.classList.remove('dark-mode');
            darkModeMensaje.classList.remove('mostrar');
        }
    })
    
    const botonDarkMode = document.querySelector('.dark-mode-boton');
    

    botonDarkMode.addEventListener( 'click' , function() {
        document.body.classList.toggle( 'dark-mode');
        darkModeMensaje.classList.toggle('mostrar');
    })
}
function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener( 'click' , navegacionResponsive);

    //Muestra capos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodo));
    
    const barra = document.querySelector('.barra');
    const contenedor = document.querySelector('.barra-contenedor');
    window.addEventListener('scroll', ()=> {
        if (window.scrollY > 112) {
            if (!barra.classList.contains('fija')) {
                contenedor.style.height = `${barra.offsetHeight}px`;
                barra.classList.add('fija');
            }
        } else {
                barra.classList.remove('fija');
                contenedor.style.height = '';
        }
    });   
}


function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    
    navegacion.classList.toggle('mostrar');

}

function mostrarMetodo(e) {
    const contactoDiv = document.querySelector('#contacto');

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Número de Teléfono</label>
            <input type="tel" placeholder="Tu telefono" id="telefono" name="contacto[telefono]" required>

            <p>Elija la fecha para la llamada</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">Ingrese su E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
        `;
        
    }
}

