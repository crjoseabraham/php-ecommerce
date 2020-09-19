export default class HttpRequest {
    constructor() {
        this.request = new XMLHttpRequest();
        this.baseURL = "http://localhost/shoppingcart/";
    }

    get(resource) {
        return new Promise((resolve, reject) => {
            this.request.addEventListener("readystatechange", () => {
                if (this.request.readyState === 4 && this.request.status === 200) {
                    const data = JSON.parse(JSON.stringify(this.request.responseText));
                    resolve(data);
                } else if (this.readyState === 4) {
                    reject("Error here dude");
                }
            });

            this.request.open("GET", this.baseURL + resource);
            this.request.send();
        });
    }

    post() {}
}
