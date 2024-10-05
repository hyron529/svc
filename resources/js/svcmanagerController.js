// Create constants model and view
const MODEL = Symbol("SvcManagerModel");
const VIEW = Symbol("SvcManagerView");

class SvcManagerController {
    // Create constructor
    constructor(model, view) {
        this[MODEL] = model;
        this[VIEW] = view;
        this.onLoad();
    }


    onLoad = () => {
        // Open Form        
        this[VIEW].bindFormValidation(
            this.handleCreateFormRegisterClient
        )
    }

    // Create form client
    handleCreateFormRegisterClient = () => {
        this[VIEW].showFormRegisterClient();
        this[VIEW].bindRegisterClientValidation(this.handleRegisterClient);
    }

    // Register Client
    handleRegisterClient = (data) => {
        console.log(data)
        fetch("/svc/seeders/createClient.php", {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
            if(!response.ok) throw new Error("Datos enviados de manera fallida.")
            return response.text();
        }).then(text=> {
            console.log(text);
        })
    }
}

export default SvcManagerController;