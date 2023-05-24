const form = document.querySelector('.form');
const formError = document.querySelector(".form__footer");
const errorDivs = new Map();
errorDivs.set('username', form.username.nextElementSibling)
    .set('email', form.email.nextElementSibling)
    .set('password', form.password.nextElementSibling)
    .set('password2', form.password2.nextElementSibling);

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    for (let errorDiv of errorDivs.values()) {
        errorDiv.textContent = "";
    }
    formError.textContent = "";

    let data = new FormData(form);

    fetch('/auth/register/handler', {
        method: 'POST',
        body: data,
    })
        .then(response => {
            if (response) {
                let headers = [...response.headers];
                headers.forEach(headerArray => {
                    if (headerArray[0] === 'x-csrf-token') {
                        form.csrf.value = headerArray[1];
                    }
                });
                return response.json();
            }
        })
        .then(json => {
            if (json) {
                console.log(json);
                if (json.hasOwnProperty("errors")) {
                    let errors = json.errors;
                    for (let key in errors) {
                        errorDivs.get(key).textContent = errors[key];
                    }
                }
                if (json.hasOwnProperty('error')) {
                    formError.textContent = json.error;
                }
                if (json.hasOwnProperty('register') && json.register === 'success') {
                    location.replace('/auth/login');
                }
            }
        })
        .catch(error => console.log(error));
});