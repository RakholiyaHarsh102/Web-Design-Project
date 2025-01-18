function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}

function registerUser(event) {
    if (!validateForm()) {
        event.preventDefault();
    } else {
        alert('User successfully registered!');
    }
}

function displayTime() {
    const footer = document.querySelector('footer');
    const now = new Date();
    footer.textContent = `Current Time: ${now.toLocaleTimeString()}`;
}

window.onload = displayTime;