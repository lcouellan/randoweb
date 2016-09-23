/**
 * Created by Lenaic on 25/04/2016.
 */
function initialize(file) {
    var mapOptions = {
        center: {lat: 44.0700674, lng: -0.362592667},
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    $.ajax({
        type: "GET",
        url: "../traces/"+file,
        dataType: "xml",
        success: function (xml) {
            var points = [];
            var bounds = new google.maps.LatLngBounds();
            $(xml).find("trkpt").each(function () {
                var lat = $(this).attr("lat");
                var lon = $(this).attr("lon");
                var p = new google.maps.LatLng(lat, lon);
                points.push(p);
                bounds.extend(p);
            });
            var poly = new google.maps.Polyline({
                // use your own style here
                path: points,
                strokeColor: "#FF00AA",
                strokeOpacity: .7,
                strokeWeight: 4
            });
            poly.setMap(map);
            // fit bounds to track
            map.fitBounds(bounds);
        }
    });
}

id = document.getElementById("identifiantRando").innerHTML;
google.maps.event.addDomListener(window, 'load', initialize(id));