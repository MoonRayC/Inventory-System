
const urlParams = new URLSearchParams(window.location.search);
const success = urlParams.get('success');
const successMessage = document.getElementById('successMessage');
const failedMessage = document.getElementById('failedMessage');

if (success === '1') {
    successMessage.textContent = 'Profile Updated Successfully';
    successMessage.removeAttribute('hidden');
    setTimeout(() => {
        successMessage.setAttribute('hidden', true);
    }, 2000);
} else if (success === '0') {
    failedMessage.textContent = 'Incorrect Password, Try Again!!!';
    failedMessage.removeAttribute('hidden');
    setTimeout(() => {
        failedMessage.setAttribute('hidden', true);
    }, 2000);

    document.getElementById('passwordError').innerHTML = 'Incorrect Password.';
    document.getElementById("oldpassword").classList.remove("border-info");
    document.getElementById("oldpassword").classList.add("is-invalid");

} else if (success === '2') {
    failedMessage.textContent = 'Failed To Updated Profile';
    failedMessage.removeAttribute('hidden');
    setTimeout(() => {
        failedMessage.setAttribute('hidden', true);
    }, 2000);
}

function editForm() {
    if (validateForm()) {
        document.getElementById("editForm").submit();
    }
}

function validateForm() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var newPassword = document.getElementById('newpassword').value;
    var confirmPassword = document.getElementById('confirmpassword').value;
    var oldPassword = document.getElementById('oldpassword').value;

    document.getElementById('usernameError').innerHTML = '';
    document.getElementById('emailError').innerHTML = '';
    document.getElementById('unmatchError1').innerHTML = '';
    document.getElementById('unmatchError2').innerHTML = '';
    document.getElementById('passwordError').innerHTML = '';

    document.getElementById("username").classList.remove("is-invalid");
    document.getElementById("email").classList.remove("is-invalid");
    document.getElementById("newpassword").classList.remove("is-invalid");
    document.getElementById("confirmpassword").classList.remove("is-invalid");
    document.getElementById("oldpassword").classList.remove("is-invalid");

    document.getElementById("username").classList.add("border-info");
    document.getElementById("email").classList.add("border-info");
    document.getElementById("newpassword").classList.add("border-info");
    document.getElementById("confirmpassword").classList.add("border-info");
    document.getElementById("oldpassword").classList.add("border-info");

    if (username === '') {
        document.getElementById('usernameError').innerHTML = 'Please Enter a Username.';
        document.getElementById("username").classList.remove("border-info");
        document.getElementById("username").classList.add("is-invalid");
        return false;
    }

    if (email === '') {
        document.getElementById('emailError').innerHTML = 'Please Enter an Email.';
        document.getElementById("email").classList.remove("border-info");
        document.getElementById("email").classList.add("is-invalid");
        return false;
    }

    if (newPassword !== confirmPassword) {
        document.getElementById('unmatchError1').innerHTML = 'Password dont match.';
        document.getElementById('unmatchError2').innerHTML = 'Password dont match.';
        document.getElementById("newpassword").classList.remove("border-info");
        document.getElementById("confirmpassword").classList.remove("border-info");
        document.getElementById("newpassword").classList.add("is-invalid");
        document.getElementById("confirmpassword").classList.add("is-invalid");
        return false;
    }

    if (oldPassword === '') {
        document.getElementById('passwordError').innerHTML = 'Enter Password to Save Changes.';
        document.getElementById("oldpassword").classList.remove("border-info");
        document.getElementById("oldpassword").classList.add("is-invalid");
        return false;
    }

    return true;
}
