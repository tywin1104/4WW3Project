function validateForm() {
    let form = document.forms["registrationForm"];
    let username = form["username"].value;
    let password = form["password"].value;
    let email = form["email"].value;
    let checked = document.getElementById("checkbox").checked;

    if (username.length < 8) {
        alert("Username must set to be at least 8 characters in length");
        return false;
    }else if(password.length < 8) {
        alert("Password must set to be at least 8 characters in length");
        return false;
    }else if(! validateEmail(email)) {
        alert("Must enter an valid email address");
        return false;
    }else if(checked === false) {
        alert("Must agree the terms & conditions in order to register");
        return false;
    }
    return true;
}

// reference: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}