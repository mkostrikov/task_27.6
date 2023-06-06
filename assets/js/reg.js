const REG = document.forms.registration;
document.addEventListener("DOMContentLoaded", () => {
    if (REG) {
        let inputs = new Map();
        inputs.set("username", REG.username)
            .set("email", REG.email)
            .set("password", REG.password)
            .set("confirm", REG.confirm);
        let togglePassword = document.querySelector(".toggle");
        let errorDiv = document.querySelector(".error");

        for (let input of inputs.values()) {
            input.addEventListener("focus", focus);
            input.addEventListener("blur", blur);
        }

        togglePassword.addEventListener("click", toggle);

        REG.addEventListener("submit", async (event) => {
            event.preventDefault();

            errorDiv.textContent = "";

            for (let input of inputs.values()) {
                input.classList.remove("invalid");
            }

            let data = new FormData(REG);
            fetch("/auth/register", {
                method: "POST",
                body: data
            })
                .then(response => {
                    let headers = [...response.headers];
                    headers.forEach(headerArray => {
                        if (headerArray[0] === 'x-csrf-token') {
                            REG.csrf.value = headerArray[1];
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
                            for (let i in json.body) {
                                inputs.get(i).classList.add("invalid");
                            }
                            break;
                        case "success":
                            let url = "/auth/success";
                            window.location.replace(url);
                            break;
                    }
                })
                .catch(error => console.log(error));
        });
    }
});
