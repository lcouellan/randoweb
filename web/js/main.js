function load(latitude,longitude) {

    var mapOptions = {
        center: {lat: latitude, lng: longitude},
        zoom: 8,
        mapTypeId: 'roadmap'
    };
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    var infoWindow = new google.maps.InfoWindow;

    downloadUrl("displayMarkers", function(data) {

        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            var id = markers[i].getAttribute("id");
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<b>" + name + "</b><br/><b><a href=\"map/"+ id + "\">Voir</a></b>";
            var marker = new google.maps.Marker({
                map: map,
                position: point
            });
            bindInfoWindow(marker, map, infoWindow, html);
        }
    });
}

function showPosition(position) {
    load(position.coords.latitude,position.coords.longitude);
}
function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    });
}
function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            callback(request, request.status);
        }
    };
    request.open('GET', url, true);
    request.send();
}
window.onload = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        load(49.173362333,-0.362592667);
    }
}