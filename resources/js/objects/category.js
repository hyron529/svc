import { EmptyValueException, InvalidConstructorException } from "../exceptions.js";

class Category { 
    #name;

    constructor(name) {
        if (name === undefined || name === "") throw new EmptyValueException("name");

        if (!(new.target === Category)) throw new InvalidConstructorException("Category");
        
        this.#name = name;
    }

    // Getters
    get name() {
        return this.#name;
    }

 
    // Setters 
    set name(value) {
        if (value === undefined || value === "") throw new EmptyValueException("name");

        this.#name = value;
    }

    toString() {
        return `Category [name = ${this.#name}`;
    }
}

export { Category };