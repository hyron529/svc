//Importamos las clases necesarias
import { createClientValidation } from "./validation.js";

//Definimos el symbol
const EXECUTE_HANDLER = Symbol("ExecuteHandler");

class SvcManagerView {
    //Constructor de la clase view donde obtenemos las referencias
    //de los elementos principales de la página y mostrar el contenido deseado
    constructor() {
        this.mainZone = document.getElementById("maincontainer");
        this.formZone = document.getElementById("formzone");
    }

    /*  
        Método privado con el que ejecutamos el controlador y manejamos los eventos, historial y desplazamiento
        Ejecutamos el controlador 
    */
    [EXECUTE_HANDLER](handler,handlerArguments,scrollElement,data,url,event) {
        //Ejecutamos el controlador
        handler(...handlerArguments);
        //Controlamos el desplazamiento
        const scroll = document.querySelector(scrollElement);
        //Desplazamos la vista al elemento si existe
        if (scroll) scroll.scrollIntoView();
        //Actualizamos el estado del navegador
        history.pushState(data, null, url);
        //Prevenimos el comportamiento por defecto del evento
        event.preventDefault();
    }

    /*
        Función para mostrar las categorías de los clientes en el desplegable
        tras loguearse. Obtenemos el menú del login y el contenedor donde están las
        categorías, para después poder insertarlas en nuestro desplegable
    */
    showClientCategories(categories) {
        const loginMenu = document.getElementById("loginMenu");
        const container = loginMenu.nextElementSibling;
        for (const category of categories) {
            container.insertAdjacentHTML(
                "beforeend",
                `<li><a class='dropdown-item'>${category.name}</a></li>` 
            )
        }
    }
    
    //Función para crear el formulario de registro de los clientes
    showFormRegisterClient() {
        //Limpiamos el contenedor
        this.mainZone.remove();
        this.formZone.replaceChildren();

        //Creamos un contenedor para mostrar el formulario de registro
        const container = document.createElement("div");
        container.id = "#newclient";

        //Insertamos el formulario
        container.insertAdjacentHTML(
            "beforeend",
            `
                <div class="container d-flex justify-content-center align-items-center vh-100">
                    <div class="register-card p-5">
                        <h2 class="text-center mb-4">
                            <span class="text-red">R</span>EGISTRO <span class="text-red">D</span>E <span class="text-red">U</span>SUARIO
                        </h2>
                        <form name="fcreateclient" role="form" id="fcreateclient" novalidate enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" placeholder="Introduce tu nombre" required>
                                <div class="invalid-feedback d-none">Debe introducir nombre.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="surname" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="surname" placeholder="Introduce tus apellidos" required>
                                <div class="invalid-feedback d-none">Debe introducir apellidos.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="dob" required>
                                <div class="invalid-feedback d-none">Debe introducir fecha nacimiento.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nacionalidad</label>
                                <input type="text" class="form-control" id="nationality" placeholder="Introduce tu nacionalidad" required>
                                <div class="invalid-feedback d-none">Debe introducir nacionalidad.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" placeholder="Introduce tu correo" required>
                                <div class="invalid-feedback d-none">Debe introducir correo.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="Introduce una contraseña" required>
                                <div class="invalid-feedback d-none">Debe introducir contraseña.</div>
                                <div class="valid-feedback">Correcto.</div>
                            </div>
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                    </div>
                </div>
            `
        );

        //Añadimos el contenido a la página principal
        this.formZone.append(container);
    }

    /*  
        Función para enlazar la vaidación del formulario de creación del cliente
        Primero obtenemos en enlace para registrarlo, y manejamos la validación y la
        ejecucción del formulario con un método privado 
    */
    bindFormValidation(createClientForm) {
        const createClientFormLink = document.getElementById("registerclient");
        createClientFormLink.addEventListener("click", event => { 
            this[EXECUTE_HANDLER] (
                createClientForm,
                [],
                "#newclient",
                { action: "createClientForm"},
                "#newclient",
                event
            ) 
        });
    }

    //Vinculamos el controlador de validación del cliente
    //y llamamos a la función con la que podemos validar los campos
    bindRegisterClientValidation (handler) {
        createClientValidation(handler);
    }
}

//Exportamos el view
export default SvcManagerView;