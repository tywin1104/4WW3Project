//Obtain user's current location via html5 geolocation API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(searchByLocation);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

//For now (Assignment 2), output the user's current location. In future (Assignment 3), this should issue a db query for backend
function searchByLocation(position) {
    alert("Search by Latitude: " + position.coords.latitude +
        " Longitude: " + position.coords.longitude);
}