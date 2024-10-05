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

function defaultCheckElement(event) {
  this.value = this.value.trim();
  if (!this.checkValidity()) {
    showFeedBack(this, false);
  } else {
    showFeedBack(this, true);
  }
}


export function createClientValidation(handler) {
    // get form
    const form = document.forms.fcreateclient;
    form.setAttribute("novalidate", true);

    form.addEventListener("submit", function(event) {
        let isValid = true;
        let firstInvalidElement = null;

        if (!this.name.checkValidity()) {
            isValid = false;
            showFeedBack(this.name, false);
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


        if (!isValid) {
            firstInvalidElement.focus();
        } else {
            const data = {
                name: this.name.value,
                surname: this.surname.value,
                birthdate: this.dob.value,
                nationality: this.nationality.value,
                email: this.email.value,
                password: this.password.value
            }

            handler(data);
        }

        event.preventDefault();
        event.stopPropagation();
    });

    
    form.name.addEventListener("change", defaultCheckElement);
    form.surname.addEventListener("change", defaultCheckElement);
    form.dob.addEventListener("change", defaultCheckElement);
    form.nationality.addEventListener("change", defaultCheckElement);
    form.email.addEventListener("change", defaultCheckElement);
    form.password.addEventListener("change", defaultCheckElement);
}