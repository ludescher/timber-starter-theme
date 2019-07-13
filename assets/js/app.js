require('../scss/app.scss');

// let link = document.getElementsByClassName("js-get-link")[0].getAttribute("data-link");
let link = "http://timber.theme.test/wp-json/timber/test/99/list/55";

console.log("Call Link: ", link);

fetch(link, {
    method: 'POST',
    headers: {
        'accept': 'application/json',
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: "franz@josef.com",
        password: "suckers"
    }),
})
.then((response) => {
    return response.json();
})
.then((myJson) => {
    console.log("myJson", myJson);
})
.catch((error) => {
    console.log("Error: ", error);
});