export default class HttpRequest {
    constructor() {
        this.request = new XMLHttpRequest();
        this.baseURL = "http://localhost/shoppingcart/";
    }

    /**
     * GET method
     * @param {string} resource It could be just a file name or a full URL
     */
    // get(resource) {
    //     return new Promise((resolve, reject) => {
    //         this.request.addEventListener("readystatechange", () => {
    //             if (
    //                 this.request.readyState === 4 &&
    //                 this.request.status === 200
    //             ) {
    //                 const data = JSON.parse(
    //                     JSON.stringify(this.request.responseText)
    //                 );
    //                 resolve(data);
    //             } else if (this.request.readyState === 4) {
    //                 reject("Could not fetch data");
    //             }
    //         });

    //         this.request.open("GET", resource);
    //         this.request.send();
    //     });
    // }

    get(resource) {
        let data;
        console.log(this.baseURL + resource);
        fetch(this.baseURL + resource)
            .then((response) => {
                console.log("response received");
                return response.json();
            })
            .then((responseData) => {
                console.log(responseData);
            })
            .catch((err) => {
                console.log("Could not fetch data");
            });
        return data;
    }
}
