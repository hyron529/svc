/*  
  Importamos los objetos y las excepciones para realizar el manager
*/
import { Category } from "./objects/category.js";
import { ExistsException, InvalidadArgumentException } from "./exceptions.js";

const SvcManager = (function () {
  //Definición de la instancia
  let instance;

  class SvcManager {
    //Definición de las variables privadas
    #name;
    #categoriescollection = new Map();

    //Constructor de la clase manager
    constructor(name = "SVC") {
      this.#name = name;
    }

    /*
      Getter que nos da acceso a las categorías contenidas en la colección
      Devolvemos un iterador con los valores almacenados en el mapa
    */
    get categories() {
        return this.#categoriescollection.values();
    }

    /*
      Método para añadir una o más categorías a la colección
      Iteramos las categorías y comprobamos si es nulo, si el objeto es correcto
      y si ya existe una con el mismo nombre. Si pasa las validaciones, agregamos 
      la categoría pasada por parámetro a la colección
    */
    addCategories(...categories) {
        for (const category of categories) {
            if(category === null) throw new InvalidadArgumentException();
            if(!(category instanceof Category)) throw new InvalidadArgumentException();
            if(this.#categoriescollection.has(category.name)) throw new ExistsException();
            this.#categoriescollection.set(category.name, category);
        }
    }

    /*
      Método para crear los objetos de tipo categoría
      Comprobamos que la colección de categorías ya tiene una con el nombre pasado
      por parámetro, y si existe, la obtenemos. En caso contrario, creamos una nueva
      instancia y retornamos la categoría.
    */
    createCategory(name, id) {
        let category;

        if(this.#categoriescollection.has(name)) {
            category = this.#categoriescollection.get(name);
        } else {
            category = new Category(name, id);
        }

        return category;
    }
  }

  /*
    Función para crear una nueva instancia de SvcManager y congelarla
    para no poder cambiar sus propiedades
  */
  function init() {
    const svcmanager = new SvcManager();
    Object.freeze(svcmanager);
    return svcmanager;
  }

  /*
    Método para verificar que existe la instancia
    Si no existe la instancia, creamos una llamando a init(),
    y después devolvemos dicha instancia
  */
  return {
    getInstance() {
      if (!instance) {
        instance = init();
      }
      return instance;
    },
  };
})();

//Exportamos el manager
export default SvcManager;
