/*
    Función para mostrar el feedback al usuario tras la validación de un input
    Primero determinamos la clase que se aadirá al input dependiendo si es válido o no
    Después seleccionamos el div adecuado para mostrar el feedback, y eliminamos cualquier mensaje
    mostrado previamente. Mostramos el feedback correcto y eliminamos las validaciones anteriores
    para añadir la nueva. En caso de haber un feedback personalizado, lo mostramos en el div correspondiente
*/
function showFeedBack(input, valid, message) {
  const validClass = valid ? "is-valid" : "is-invalid";
  const messageDiv = valid
    ? input.parentElement.querySelector("div.valid-feedback")
    : input.parentElement.querySelector("div.invalid-feedback");
  for (const div of input.parentElement.getElementsByTagName("div")) {
    div.classList.remove("d-block");
  }
  messageDiv.classList.remove("d-none");
  messageDiv.classList.add("d-block");
  input.classList.remove("is-valid");
  input.classList.remove("is-invalid");
  input.classList.add(validClass);
  if (message) {
    messageDiv.innerHTML = message;
  }
}

/*
    Función empleada para ser ejecutada cuando se pierde el foco o se cambia
    un campo del formulario. Eliminamos los espacios en blanco del valor del input
    y si el campo no es válido, mostramos el feedback negativo, en caso contrario,
    mostramos el positivo
*/
function defaultCheckElement(event) {
  this.value = this.value.trim();
  if (!this.checkValidity()) {
    showFeedBack(this, false);
  } else {
    showFeedBack(this, true);
  }
}

/*
    Función para la validación del formulario de registro del cliente
*/
export function createClientValidation(handler) {
    //Obtenemos el formuario por su nombre y desactivamos la navegación nativa del navegador
    const form = document.forms.fcreateclient;
    form.setAttribute("novalidate", true);

    //Añadimos un event listener para el evento submit
    form.addEventListener("submit", function(event) {
        let isValid = true;
        let firstInvalidElement = null;

        //Validación para cada campo del formulario
        if (!this.name.checkValidity()) {
            isValid = false;
            showFeedBack(this.name, false);
            //Guarda el primer campo inválido para hacerle focus
            firstInvalidElement = this.name;
        } else {
            showFeedBack(this.name, true);
        }

        if (!this.surname.checkValidity()) {
            isValid = false;
            showFeedBack(this.surname, false);
            firstInvalidElement = this.surname;
        } else {
            showFeedBack(this.surname, true);
        }

        if (!this.dob.checkValidity()) {
            isValid = false;
            showFeedBack(this.dob, false);
            firstInvalidElement = this.dob;
        } else {
            showFeedBack(this.dob, true);
        }

        if (!this.nationality.checkValidity()) {
            isValid = false;
            showFeedBack(this.nationality, false);
            firstInvalidElement = this.nationality;
        } else {
            showFeedBack(this.name, true);
        }

        if (!this.email.checkValidity()) {
            isValid = false;
            showFeedBack(this.email, false);
            firstInvalidElement = this.email;
        } else {
            showFeedBack(this.email, true);
        }

        if (!this.password.checkValidity()) {
            isValid = false;
            showFeedBack(this.password, false);
            firstInvalidElement = this.password;
        } else {
            showFeedBack(this.password, true);
        }

        //Hacemos foco en el primer elemento inválido si dicho formulario es erróneo
        if (!isValid) {
            firstInvalidElement.focus();
        } else {
            //Construimos el objeto con la info del cliente si el formulario es válido
            const data = {
                name: this.name.value,
                surname: this.surname.value,
                birthdate: this.dob.value,
                nationality: this.nationality.value,
                email: this.email.value,
                password: this.password.value
            }

            //Llamamos al manejador pasado como argumento para procesar los datos del clliente
            handler(data);
        }

        //Prevenimos que el formulario se envíe de forma estándar
        event.preventDefault();
        event.stopPropagation();
    });

    //Finalmente, añadimos validacion cuando el usuario cambie alguno de los campos del formulario
    form.name.addEventListener("change", defaultCheckElement);
    form.surname.addEventListener("change", defaultCheckElement);
    form.dob.addEventListener("change", defaultCheckElement);
    form.nationality.addEventListener("change", defaultCheckElement);
    form.email.addEventListener("change", defaultCheckElement);
    form.password.addEventListener("change", defaultCheckElement);
}