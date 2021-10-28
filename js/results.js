// using google map API to embed markers for each restaurant in the map
function addMarker(map, position, contentString, link) {
    const infowindow = new google.maps.InfoWindow({
        content: `<p>${contentString}</p> <a href="${link}">See Details</a>`
    });
    const marker = new google.maps.Marker({
        position: position,
        map,
    });

    marker.addListener("click", () => {
        infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
        });
    });
}

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        // Toronto as the center
        center: {lat: 43.651070, lng: -79.347015},
    })
    // for now since we hard code to only have 1 detail page, all links to there
    // will direct to different pages once we have Assignment 3 in place
    addMarker(map, {lat: 43.651070, lng: -79.347015}, "Island Grill", "./individual_sample.html");
    addMarker(map, {lat: 43.702168, lng: -79.414453}, "Flavoroso", "./individual_sample.html");
    addMarker(map, {lat: 43.680252, lng: -79.314683}, "Green Curry", "./individual_sample.html");
    addMarker(map, {lat: 43.666722, lng: -79.344615}, "El Pirata Porch", "./individual_sample.html");
    addMarker(map, {lat: 43.744973, lng: -79.722730}, "Sweet Escape", "./individual_sample.html");
    addMarker(map, {lat: 43.764223, lng: -79.439690}, "Xin Chao Vietnamese Restaurant", "./individual_sample.html");

}