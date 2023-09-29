function SenhaConfirm(event){
    var password = document.querySelector("#password");
    var confirmPassword = document.querySelector("#confirmPassword");

    if(confirmPassword.value != password.value){
        alert('As senhas são diferentes');
        event.preventDefault();
    }
}
function Clean() {
    var nameInput = document.getElementById("name");
    var emailInput = document.getElementById("email");
    var telInput = document.getElementById("tel");
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirmPassword");
    
    nameInput.value = "";
    emailInput.value = "";
    telInput.value = "";
    passwordInput.value = "";
    confirmPasswordInput.value = "";
}
function register() {
    
    const register = document.querySelector('.register')
    const entrar = document.querySelector('.entrar')

    if(register.style.display == 'none'){
        register.style.display = 'block';
        entrar.disabled = true
    }else{
        register.style.display = 'none';
        entrar.disabled = false
    }

}