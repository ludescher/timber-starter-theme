require('../scss/app.scss');

fetch('http://timber.theme.test:3000/foo/3', {
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
    console.log(myJson);
})
.catch((error) => {
    console.error(error);
});