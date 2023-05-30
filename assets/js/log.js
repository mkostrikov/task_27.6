const form = document.querySelector(".form");
const formError = document.querySelector(".form__footer");

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    formError.textContent = "";

    let data = new FormData(form);

    fetch('/auth/login', {
        method: "POST",
        body: data
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
                if (json.hasOwnProperty('error')) {
                    formError.textContent = json.error;
                }
                if (json.hasOwnProperty('login') && json.login === 'success') {
                    location.replace('/dashboard');
                }
            }
        })
        .catch(error => console.log(error));

});