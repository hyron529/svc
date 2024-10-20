import { EmptyValueException, InvalidConstructorException } from "../exceptions.js";

/*
    Clase donde vamos a definir el objeto categoría
    Con esto podemos mostrar la información del desplegable una vez que 
    hemos iniciado sesión
*/
class Category { 
    #name;

    //Constructor de la clase category, y controlamos que el nombre
    //no esté vacío o que sea un objeto category
    constructor(name) {
        if (name === undefined || name === "") throw new EmptyValueException("name");

        if (!(new.target === Category)) throw new InvalidConstructorException("Category");
        
        this.#name = name;
    }

    //Getter
    get name() {
        return this.#name;
    }

 
    //Setter
    set name(value) {
        if (value === undefined || value === "") throw new EmptyValueException("name");

        this.#name = value;
    }

    //toString para mostrar el nombre de la categoría 
    toString() {
        return `Category [name = ${this.#name}`;
    }
}

//Exportamos la clase
export { Category };