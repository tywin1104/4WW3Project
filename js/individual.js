function initMap() {
    // using google map API to embed markers for the current restaurant in the map
    const map = new google.maps.Map(document.getElementById("individualMap"), {
        zoom: 10,
        // Toronto as the center
        center: {lat: 43.651070, lng: -79.347015},
    })
    new google.maps.Marker({
        position: {lat: 43.651070, lng: -79.347015},
        map,
    });
}