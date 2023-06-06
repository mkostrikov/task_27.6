function focus() {
    this.placeholder = "";
    showLabel(this.name);
}

function blur() {
    if (!this.value) {
        this.placeholder = ucFirst(this.name);
        hideLabel(this.name);
    }
}

function toggle() {
    let input = document.querySelector("input[name=password]");
    if (input.type === "password") {
        viewPassword(input, this);
        return;
    }
    if (input.type === "text") {
        hidePassword(input, this);
    }
}

function showLabel(inputName) {
    let label = document.querySelector(`.${inputName}-label`);
    label.textContent = ucFirst(inputName);
}

function hideLabel(inputName) {
    let label = document.querySelector(`.${inputName}-label`);
    label.textContent = "";
}

function viewPassword(password, toggle) {
    if (password && toggle) {
        password.type = "text";
        toggle.classList.remove("hide");
        toggle.classList.add("show");
    }
}

function hidePassword(password, toggle) {
    if (password && toggle) {
        password.type = "password";
        toggle.classList.remove("show");
        toggle.classList.add("hide");
    }
}

function ucFirst(string) {
    if (!string) {
        return string;
    }
    return string[0].toUpperCase() + string.slice(1);
}