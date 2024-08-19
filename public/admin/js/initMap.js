var lat;
var lng;

function setCoordinates(lat = null, lng = null) {
  this.lat = lat ?? '24.713552';
  this.lng = lng ?? '46.675297';
}

function GetAddress() {
  var lat = parseFloat(document.getElementById("lat").value);
  var lng = parseFloat(document.getElementById("lng").value);
  // console.log('lat'+ lat );
  // console.log('lng'+ lng );
  var latlng = new google.maps.LatLng(lat, lng);
  var geocoder = geocoder = new google.maps.Geocoder();
  geocoder.geocode({
    'latLng': latlng
  }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        $('#address').val(results[1].formatted_address);
      }
    }
  });
}

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {
      lat: this.lat,
      lng: this.lng
    }
  });
  var markerOne = new google.maps.Marker({
    position: {
      lat: this.lat,
      lng: this.lng
    },
    map: map,
    draggable: true
  });


  var searchBox = new google.maps.places.SearchBox(document.getElementById('location'));

  google.maps.event.addListener(searchBox, 'places_changed', function () {
    var places = searchBox.getPlaces();
    var boundsOne = new google.maps.LatLngBounds();
    var i, place;

    for (i = 0; place = places[i]; i++) {
      boundsOne.extend(place.geometry.location);
      markerOne.setPosition(place.geometry.location);
    }
    map.fitBounds(boundsOne);
    map.setZoom(15);
  });

  google.maps.event.addListener(markerOne, 'position_changed', function () {

    // var lat = markerOne.getPosition().lat();
    // var lng = markerOne.getPosition().lng();
    $('#lat').val(markerOne.getPosition().lat());
    $('#lng').val(markerOne.getPosition().lng());
    GetAddress();

  });

}
