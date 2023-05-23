const form = document.querySelector('.form');

const errors = new Map();
errors.set('username', form.username.nextElementSibling)
    .set('email', form.email.nextElementSibling)
    .set('password', form.password.nextElementSibling)
    .set('password2', form.password2.nextElementSibling);

form.addEventListener('submit', async (event) => {
    event.preventDefault();

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
                if (!json.hasOwnProperty("id")) {
                    for (let error of errors.values()) {
                        error.textContent = "";
                    }
                    for (let key in json) {
                        errors.get(key).textContent = json[key];
                    }
                } else {
                    location.replace('/auth/login');
                }
            }
        })
        .catch(error => console.log(error));
});