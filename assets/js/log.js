const LOG = document.forms.login;
document.addEventListener("DOMContentLoaded", () => {
    if (LOG) {
        let inputs = new Map();
        inputs.set("email", LOG.email)
            .set("password", LOG.password)
        let togglePassword = document.querySelector(".toggle");
        let errorDiv = document.querySelector(".error");

        for (let input of inputs.values()) {
            input.addEventListener("focus", focus);
            input.addEventListener("blur", blur);
        }

        togglePassword.addEventListener("click", toggle);

        LOG.addEventListener("submit", async (event) => {
            event.preventDefault();

            errorDiv.textContent = "";

            let data = new FormData(LOG);
            fetch("/auth/login", {
                method: "POST",
                body: data
            })
                .then(response => {
                    let headers = [...response.headers];
                    headers.forEach(headerArray => {
                        if (headerArray[0] === 'x-csrf-token') {
                            LOG.csrf.value = headerArray[1];
                        }
                    });
                    return response.json();
                })
                .then(json => {
                    switch (json.status) {
                        case "error":
                            errorDiv.textContent = json.body;
                            break;
                        case "invalid":
                            errorDiv.textContent = json.body;
                            break;
                        case "success":
                            let url = "/dashboard";
                            window.location.replace(url);
                            break;
                    }
                })
                .catch(error => console.log(error));
        });
    }
});
