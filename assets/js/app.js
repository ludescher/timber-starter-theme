require('../scss/app.scss');

let link = document.getElementsByClassName("js-get-link")[0].getAttribute("data-link");

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
    console.log(response);
    return response.json();
})
.then((myJson) => {
    console.log(myJson);
})
.catch((error) => {
    console.error(error);
});