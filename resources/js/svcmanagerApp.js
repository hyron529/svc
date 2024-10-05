import SvcManager from "./svcmanager.js"
import SvcManagerController from "./svcmanagerController.js"
import SvcManagerView from "./svcmanagerView.js"

const SvcManagerApp = new SvcManagerController (
    SvcManager.getInstance(),
    new SvcManagerView
)

export default SvcManagerApp;