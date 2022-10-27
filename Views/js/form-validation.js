const userNameField = document.querySelector("[name = email]");
const passwordField = document.querySelector("[name = password]");

userNameField.addEventListener("blur", function(e){
    const field = e.target;
    const fieldValue = e.target.value;
    if(field.lenght == 0){
        field.parentElement.insertAdjacentHTML(
            "beforeend",
            '<span class="error">Aca va el error</span>'
        );
    }
})