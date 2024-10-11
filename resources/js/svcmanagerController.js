// Create constants model and view
const MODEL = Symbol("SvcManagerModel");
const VIEW = Symbol("SvcManagerView");
const LOAD_MANAGER_OBJECTS = Symbol("LOAD_MANAGER_OBJECTS");

class SvcManagerController {
  // Create constructor
  constructor(model, view) {
    this[MODEL] = model;
    this[VIEW] = view;
    this.onLoad();
  }

  [LOAD_MANAGER_OBJECTS](data) {
    const categories = data.role.client.category;

    for( const category of categories) {
        const c = this[MODEL].createCategory(category.title);
        this[MODEL].addCategories(c);
    }
  }

  onLoad = () => {
    fetch("/svc/seeders/datauser.php").then(async (response) => {
      if (!response.ok) return;

      // Get client info
      const client =  await response.json();
        console.log(client)

      if (client.valid) {
        // Get data
        fetch("./data/categories.json", {
          method: "get",
        })
          .then((response) => response.json())
          .then((data) => {
            this[LOAD_MANAGER_OBJECTS](data)
          })
          .then(() => {
            this[VIEW].showClientCategories(this[MODEL].categories);
          })
          .catch((error) => {
            console.log("Error load json " + error);
          });
      }
    });

    // Open Form
    this[VIEW].bindFormValidation(this.handleCreateFormRegisterClient);
  };

  // Create form client
  handleCreateFormRegisterClient = () => {
    this[VIEW].showFormRegisterClient();
    this[VIEW].bindRegisterClientValidation(this.handleRegisterClient);
  };

  // Register Client
  handleRegisterClient = (data) => {
    console.log(data);
    fetch("/svc/seeders/createClient.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => {
        if (!response.ok) throw new Error("Datos enviados de manera fallida.");
        return response.text();
      })
      .then((text) => {
        console.log(text);
      });
  };
}

export default SvcManagerController;
