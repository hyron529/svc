//Importamos los objetos
import SvcManager from "./svcmanager.js"
import SvcManagerController from "./svcmanagerController.js"
import SvcManagerView from "./svcmanagerView.js"

//Creamos el objeto al que le pasamos las instancias del modelo vista controlador
const SvcManagerApp = new SvcManagerController (
    SvcManager.getInstance(),
    new SvcManagerView
)

//Exportamos el objeto SvcManagerApp
export default SvcManagerApp;