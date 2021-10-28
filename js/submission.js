let autofillLocationButton = document.getElementById("autofillLocationButton ");

//Obtain user's current location via html5 geolocation API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(autofillLocation);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

//Set form's location input values automatically using obtained user location from geolocation API
function autofillLocation(position) {
    let submissionFieldLat = document.getElementById("submissionFieldLat");
    let submissionFieldLon = document.getElementById("submissionFieldLon");
    submissionFieldLat.value = position.coords.latitude;
    submissionFieldLon.value = position.coords.longitude;
}