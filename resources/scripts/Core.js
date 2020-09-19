import HttpRequest from "./HttpRequest";
import Carousels from "./Carousels";

export default class Core {
    constructor() {
        this.Http = new HttpRequest();
        this.Carousels = new Carousels();
    }
}
