import { Category } from "./objects/category.js";
import { ExistsException, InvalidadArgumentException } from "./exceptions.js";

const SvcManager = (function () {
  // Create instace
  let instance;

  class SvcManager {
    // Private variables
    #name;
    #categoriescollection = new Map();

    constructor(name = "SVC") {
      this.#name = name;
    }

    get categories() {
        return this.#categoriescollection.values();
    }

    addCategories(...categories) {
        for (const category of categories) {
            if(category === null) throw new InvalidadArgumentException();
            if(!(category instanceof Category)) throw new InvalidadArgumentException();
            if(this.#categoriescollection.has(category.name)) throw new ExistsException();
            this.#categoriescollection.set(category.name, category);
        }
    }

    createCategory(name) {
        let category;

        if(this.#categoriescollection.has(name)) {
            category = this.#categoriescollection.get(name);
        } else {
            category = new Category(name);
        }

        return category;
    }
  }

  function init() {
    const svcmanager = new SvcManager();
    Object.freeze(svcmanager);
    return svcmanager;
  }

  return {
    getInstance() {
      if (!instance) {
        instance = init();
      }
      return instance;
    },
  };
})();

export default SvcManager;
