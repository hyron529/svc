//Declaramos las constantes para el modelo, la vista y el método de carga
const MODEL = Symbol("SvcManagerModel");
const VIEW = Symbol("SvcManagerView");
const LOAD_MANAGER_OBJECTS = Symbol("LOAD_MANAGER_OBJECTS");

//creación de la clase que contrendrá nuestro controlador
class SvcManagerController {

  //Contructor al que le pasamos el modelo y la vista
  constructor(model, view) {
    //Asignamos el modelo al Symbol
    this[MODEL] = model;
    //Asignamos la vista al Symbol
    this[VIEW] = view;
    //Llamamos a onLoad cuando se instancia la clase
    this.onLoad();
  }

  /*
    Método privado para cargar objetos de categorías en el modelo
    Primero obtenemos las categorías que tenemos, y después iteramos sobre ellas
    y las agregamos al modelo
  */
  [LOAD_MANAGER_OBJECTS](data) {
    const categories = data.role.client.category;

    for( const category of categories) {
        const c = this[MODEL].createCategory(category.title);
        this[MODEL].addCategories(c);
    }
  }

  /*
    Método que se ejecuta siempre que cargamos la página
  */
  onLoad = () => {

    //Realizamos una soluicitud para obtener los datos del usuario
    fetch("/svc/seeders/datauser.php").then(async (response) => {
      if (!response.ok) return;

      //Convertimos la información en JSON
      const client =  await response.json();
        console.log(client)

      //Cargamos los datos de las categorías si el cliente es válido
      if (client.valid) {
        // Get data
        fetch("./data/categories.json", {
          method: "get",
        })
        //Convertimos a JSON y llamamos al método privado con el que
        //cargamos las categorías, y luego las mostramos en la vista
          .then((response) => response.json())
          .then((data) => {
            this[LOAD_MANAGER_OBJECTS](data)
          })
          .then(() => {
            this[VIEW].showClientCategories(this[MODEL].categories);
          })
          //Controlamos los errores
          .catch((error) => {
            console.log("Error load json " + error);
          });
      }
    });

    //Abrimos el formulario de registro del cliente
    this[VIEW].bindFormValidation(this.handleCreateFormRegisterClient);
  };

  //Manejador para el formulario de registro del cliente
  handleCreateFormRegisterClient = () => {
    this[VIEW].showFormRegisterClient();
    this[VIEW].bindRegisterClientValidation(this.handleRegisterClient);
  };

  //Manejador para el registro del cliente, aquí enviamos los datos del cliente
  //al servidor, y los enviamos en formato JSON
  handleRegisterClient = (data) => {
    console.log(data);
    fetch("/svc/seeders/createClient.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(data),
    })
    //Lanzamos un error si la solicitud es fallida
      .then((response) => {
        if (!response.ok) throw new Error("Datos enviados de manera fallida.");
        return response.text();
      })
      .then((text) => {
        console.log(text);
      });
  };
}

//Exportamos el controller
export default SvcManagerController;
