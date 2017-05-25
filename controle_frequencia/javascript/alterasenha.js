var form = document.getElementById("alterar_senha");

form.onsubmit = function() {

	var newPassword = document.getElementById('new_password');
	var confirmPassword = document.getElementById('confirm_new_password');

	if (new_password.value != confirmPassword.value) {
		alert("Insira a mesma senha duas vezes para confirmá-la.");
	}

}