//Importamos las clases necesarias
import { createBrandValidation, createClientValidation } from "./validation.js";
import { setCookie } from "./cookie.js";

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
  [EXECUTE_HANDLER](
    handler,
    handlerArguments,
    scrollElement,
    data,
    url,
    event
  ) {
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
        `<li><a data-id="${category.id}" class='dropdown-item'>${category.name}</a></li>`
      );
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
                <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding-top: 10px; padding-bottom: 10px;">
                  <div class="register-card p-5">
                      <h2 class="text-center mb-4">
                          <span class="text-red">R</span>EGISTRO <span class="text-red">D</span>E <span class="text-red">U</span>SUARIO
                      </h2>
                      <form name="fcreateclient" role="form" id="fcreateclient" novalidate enctype="multipart/form-data">
                          <div class="mb-3">
                              <label for="name" class="form-label">Nombre</label>
                              <input type="text" class="form-control" id="name" placeholder="Introduzca su nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Debe introducir su nombre correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="surname" class="form-label">Apellidos</label>
                              <input type="text" class="form-control" id="surname" placeholder="Introduzca sus apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Debe introducir sus apellidos correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="dob" class="form-label">Fecha de nacimiento</label>
                              <input type="date" class="form-control" id="dob" required>
                              <div class="invalid-feedback d-none">Debe introducir su fecha de nacimiento.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="nationality" class="form-label">Nacionalidad</label>
                              <input type="text" class="form-control" id="nationality" placeholder="Introduzca su nacionalidad" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Debe introducir su nacionalidad correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="email" class="form-label">Correo Electrónico</label>
                              <input type="email" class="form-control" id="email" placeholder="Introduzca su correo" required>
                              <div class="invalid-feedback d-none">Debe introducir un correo válido.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="password" class="form-label">Contraseña</label>
                              <input type="password" class="form-control" id="password" placeholder="Introduzca una contraseña" pattern=".{6,}" required>
                              <div class="invalid-feedback d-none">La contraseña debe tener al menos 6 caracteres.</div>
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

  //Función para crear el formulario de registro de las marcas
  showFormRegisterBrand() {
    //Limpiamos el contenedor
    this.mainZone.remove();
    this.formZone.replaceChildren();

    //Creamos un contenedor para mostrar el formulario de registro
    const container = document.createElement("div");
    container.id = "#newbrand";

    //Insertamos el formulario
    container.insertAdjacentHTML(
      "beforeend",
      `
            <form name="fcreatebrand" role="form" id="fcreatebrand" novalidate enctype="multipart/form-data">
                <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding-top: 10px; padding-bottom: 10px;">
                  <div class="register-card p-5">
                      <h2 class="text-center mb-4">
                          <span class="text-red">R</span>EGISTRO <span class="text-red">D</span>E <span class="text-red">M</span>ARCA
                      </h2>
                      <form name="fcreatebrand" role="form" id="fcreatebrand" novalidate enctype="multipart/form-data">
                          <div class="mb-3">
                              <label for="brandName" class="form-label">Nombre de la Marca</label>
                              <input type="text" class="form-control" id="brandName" placeholder="Introduzca el nombre de la marca" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Introduzca el nombre de la marca correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="foundationDate" class="form-label">Fecha de Fundación</label>
                              <input type="date" class="form-control" id="foundationDate" required>
                              <div class="invalid-feedback d-none">Introduzca una fecha válida.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="country" class="form-label">País de Origen</label>
                              <input type="text" class="form-control" id="country" placeholder="Introduzca el país de origen" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Introduzca el país de origen correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="headquarters" class="form-label">Sede Principal</label>
                              <input type="text" class="form-control" id="headquarters" placeholder="Introduzca la sede principal" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                              <div class="invalid-feedback d-none">Introduzca la sede principal correctamente (solo letras y espacios).</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="email" class="form-label">Correo Electrónico de Contacto</label>
                              <input type="email" class="form-control" id="email" placeholder="Introduzca el correo de contacto" required>
                              <div class="invalid-feedback d-none">Introduzca un correo válido.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="website" class="form-label">Sitio Web</label>
                              <input type="url" class="form-control" id="website" placeholder="Introduzca la URL del sitio web" required>
                              <div class="invalid-feedback d-none">Introduzca una URL válida.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="mb-3">
                              <label for="password" class="form-label">Contraseña</label>
                              <input type="password" class="form-control" id="password" placeholder="Introduzca una contraseña" pattern=".{6,}" required>
                              <div class="invalid-feedback d-none">La contraseña debe tener al menos 6 caracteres.</div>
                              <div class="valid-feedback">Correcto.</div>
                          </div>
                          <div class="d-grid gap-2 mb-3">
                              <button type="submit" class="btn btn-primary">Registrar Marca</button>
                          </div>
                      </form>
                  </div>
              </div>
            </form>
            `
    );

    //Añadimos el contenido a la página principal
    this.formZone.append(container);
  }

  /*
  
    COOKIES
  
  */
  // Metodo que llamaremos desde nuestro controlador para mostrar el mensaje
  // al usuario de que tiene que aceptar o denegar el uso de cookies
  showCookies() {
    // Definimos el div que contiene el mensaje de aviso de las cookies
    const toast = `
    <div class="fixed-top p-5 mt-5">
  <div
    id="cookies-message"
    class="toast fade show bg-secondary text-light w-100 mw-100"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
  >
    <div class="toast-header bg-dark text-white">
      <h4 class="me-auto" style="font-family: 'secundaria', sans-serif;">Aviso de Cookies</h4>
      <button
        type="button"
        class="btn-close btn-close-white"
        data-bs-dismiss="toast"
        aria-label="Cerrar"
        id="btnDismissCookie"
      ></button>
    </div>
    <div class="toast-body p-4 d-flex flex-column">
      <p class="mb-3" style="font-family: 'secundaria', sans-serif;">
        Usamos cookies para mejorar tu experiencia y análisis de navegación. Es necesario aceptarlas para disfrutar al máximo de nuestros servicios.
      </p>
      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-outline-danger me-3 text-light"
          id="btnDenyCookie"
          data-bs-dismiss="toast"
          style="font-family: 'secundaria', sans-serif;"
        >
          Rechazar
        </button>
        <button
          type="button"
          class="btn btn-outline-success text-light"
          id="btnAcceptCookie"
          data-bs-dismiss="toast"
          style="font-family: 'secundaria', sans-serif;"
        >
          Aceptar
        </button>
      </div>
    </div>
  </div>
</div>
  `;

    // Añadimos el div con el contenido a nuestra pagina
    document.body.insertAdjacentHTML("afterbegin", toast);

    // Vamos a controlar los eventos que boostrap genera al ser cerrado el mensaje
    // independientemente del metodo que se este usando
    const cookiesMessage = document.getElementById("cookies-message");
    cookiesMessage.addEventListener("hidden.bs.toast", (event) => {
      // Eliminamos la notificacion del arbol dom de nuestra pagina
      event.currentTarget.parentElement.remove();
    });

    // Añadimos un manejador para cuando se haga click en los botones de cerrar de nuestra notificacion
    // para que se muestre un mensaje de que no se puede continuar navegando de la pagina si no 
    // son aceptada las cookies por parte del usuario
    const denyCookieFunction = (event) => {
      // Eliminamos el contenido de la parte incial y central de nuestra pagina para mostrar el respectivo mensaje
      this.mainZone.replaceChildren();

      // Mostramos el mensaje en la parte inicial de nuestra pagina
      this.mainZone.insertAdjacentHTML(
        "afterbegin",
        `
          <div class="container my3">
            <div class="alert alert-warning" role="alert">
              <strong>Es imprescindible aceptar el uso de cookies para poder usar esta web. 
              Por favor, recargue la página y acepte las condiciones para continuar navegando.</strong>
            </div>
          </div>
        `
      );

      this.mainZone.remove();
    };

    // Si se pulsa alguno de los botones de denegar de nuestra notificacion capturamos el evento 
    // y mostramos el mensaje de que el usuario no podra navegar en nuestra pagina si no acepta las cookies
    // 1 boton de denegar
    const btnDenyCookie = document.getElementById("btnDenyCookie");
    btnDenyCookie.addEventListener("click", denyCookieFunction);

    // 2 boton de denegar
    const btnDismissCookie = document.getElementById("btnDismissCookie");
    btnDismissCookie.addEventListener("click", denyCookieFunction);

    // Si hacemos click en el boton de aceptar capturamos el evento y establecemos la cookies
    const btnAcceptCookie = document.getElementById('btnAcceptCookie');
    btnAcceptCookie.addEventListener("click", (event) => {
      setCookie("acceptedCookieMessage", "true", 1);
    });
  }

  /*  
        Función para enlazar la validación del formulario de creación del cliente
        Primero obtenemos en enlace para registrarlo, y manejamos la validación y la
        ejecucción del formulario con un método privado 
    */
  bindFormValidation(createClientForm, createBrandForm) {
    const createClientFormLink = document.getElementById("registerclient");
    createClientFormLink.addEventListener("click", (event) => {
      this[EXECUTE_HANDLER](
        createClientForm,
        [],
        "#newclient",
        { action: "createClientForm" },
        "#newclient",
        event
      );
    });
    const createBrandLinkForm = document.getElementById("registerbrand");
    createBrandLinkForm.addEventListener("click", (event) => {
      this[EXECUTE_HANDLER](
        createBrandForm,
        [],
        "#newbrand",
        { action: "createbrandform" },
        "#newbrand",
        event
      );
    });
  }

  bindClientCategories(handler) {
    const loginMenu = document.getElementById("dropdown-menu");
    const links = loginMenu.querySelectorAll("li a");

    for (const link of links) {
      link.addEventListener("click", (event) => {
        const {id} = event.currentTarget.dataset;
        handler(id);
      })
    }
  }


  //Vinculamos el controlador de validación del cliente
  //y llamamos a la función con la que podemos validar los campos
  bindRegisterClientValidation(handler) {
    createClientValidation(handler);
  }

  //Vinculamos el controlador de validación de la marca
  //y llamamos a la función con la que podemos validar los campos
  bindBrandFormValidation(handler) {
    createBrandValidation(handler);
  }


  // Modals
  showClientModal(done) {
    const messageModalContainer = document.getElementById("messageModal");
    const messageModal = new bootstrap.Modal("#messageModal");

    const title = document.getElementById("messageModalTitle");
    title.innerHTML = "Registro correcto";
    const body = messageModalContainer.querySelector(".modal-body");
    body.replaceChildren();
    if (done) {
      body.insertAdjacentHTML(
        "afterbegin",
        `<div class="p-3">El usuario ha sido creado de manera correcta.</div>`
      );
    } else {
      body.insertAdjacentHTML(
        "afterbegin",
        `<div class="error text-danger p-3"><i class="bi bi-exclamation-triangle">Hubo un error al intentar crear el usuario.</div>`
      );
    }
    messageModal.show();
    const listener = (event) => {
      if (done) {
        document.fcreateclient.reset();
        window.location.href = "/svc/web/login.php"
      }
      document.fcreateclient.name.focus();
    };
    messageModalContainer.addEventListener("hidden.bs.modal", listener, {
      once: true,
    });
  }

  showBrandModal(done) {
    const messageModalContainer = document.getElementById("messageModal");
    const messageModal = new bootstrap.Modal("#messageModal");

    const title = document.getElementById("messageModalTitle");
    title.innerHTML = "Registro correcto";
    const body = messageModalContainer.querySelector(".modal-body");
    body.replaceChildren();
    if (done) {
      body.insertAdjacentHTML(
        "afterbegin",
        `<div class="p-3">La marca ha sido creada de manera correcta.</div>`
      );
    } else {
      body.insertAdjacentHTML(
        "afterbegin",
        `<div class="error text-danger p-3"><i class="bi bi-exclamation-triangle">Hubo un error al intentar crear la marca.</div>`
      );
    }
    messageModal.show();
    const listener = (event) => {
      if (done) {
        document.fcreatebrand.reset();
        window.location.href = "/svc/web/login.php"
      }
      document.fcreatebrand.brandName.focus();
    };
    messageModalContainer.addEventListener("hidden.bs.modal", listener, {
      once: true,
    });
  }
}

//Exportamos el view
export default SvcManagerView;
