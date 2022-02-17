function chkPassword() {

    var password1 = document.getElementById('password1'); 
    var password2 = document.getElementById('password2'); 
    document.getElementsByName

    if (password1.value.length < 4) {
        alert("Bitte geben sie ein Passwort mit mindestens 4 Zeichen ein!");
        password1.focus();
        return false;
    }
    if (password1.value != password2.value) {
        alert("Die von ihnen eingegebenen Passwörter sind nicht identisch!");
        password2.focus();
        return false;
    }
}
var b_register = document.getElementById('registerForm'); 
    b_register.addEventListener('submit', chkFormular, true); 
