//Obtain user's current location via html5 geolocation API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(searchByLocation);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

// Post location data to search form via AJAX so that PHP side can process them as normal
function searchByLocation(position) {
    document.getElementById("searchFieldUserLocationLat").value = position.coords.latitude;
    document.getElementById("searchFieldUserLocationLong").value = position.coords.longitude;
    document.getElementById('searchForm').submit();
}