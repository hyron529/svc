const SvcManager = (function () {
 // Create instace
 let instance;

 class SvcManager { 
     // Private variables
     #name;

     constructor(name = "SVC") {
        this.#name = name;
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
    }
 }
})();

export default SvcManager;