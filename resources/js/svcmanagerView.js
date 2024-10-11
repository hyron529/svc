import { createClientValidation } from "./validation.js";

const EXECUTE_HANDLER = Symbol("ExecuteHandler");

class SvcManagerView {
    constructor() {
        this.mainZone = document.getElementById("maincontainer");
        this.formZone = document.getElementById("formzone");
    }

    [EXECUTE_HANDLER](handler,handlerArguments,scrollElement,data,url,event) {
        handler(...handlerArguments);
        const scroll = document.querySelector(scrollElement);
        if (scroll) scroll.scrollIntoView();
        history.pushState(data, null, url);
        event.preventDefault();
    }

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
    
    // Create register client form
    showFormRegisterClient() {
        // Clean main zone
        this.mainZone.remove();
        this.formZone.replaceChildren();

        // Create form container
        const container = document.createElement("div");
        container.id = "#newclient";

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

        // Add contianer to main page
        this.formZone.append(container);
    }


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

    bindRegisterClientValidation (handler) {
        createClientValidation(handler);
    }
}

export default SvcManagerView;