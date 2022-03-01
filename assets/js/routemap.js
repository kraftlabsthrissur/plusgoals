var directionsService;
var directionsDisplay;
initMap = function () {
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {lat: 20.5937, lng: 78.9629},
        mapTypeIds: 'roadmap'
    });
    directionsDisplay.setMap(map);

    var input = document.getElementById('selected_location');
    //var autocomplete = new google.maps.places.Autocomplete(input);
    var autocomplete = new google.maps.places.SearchBox(input);
    $('#selected_location').attr('placeholder', "Enter a location");

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
    if ($('#route li').length > 0) {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    }
};
$(document).ready(function () {
    $('body').on('click', '.add_route_place', function () {
        addRoutePlaces();
    });
    $('body ').on('click', '.closeList', function () {
        $(this).parents('li').remove();
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
});

function addRoutePlaces() {
    var id = [];
    var place;
    $('.checkboxStore:checked').each(function () {
        var customer_id = $(this).attr('id');
        var customer_name = $(this).parents('tr').find('.customer_name').text();
        var area = $(this).parents('tr').find('.area').text();
        var location = $(this).parents('tr').find('.location').text();
        $('.route_places').removeClass('hidden');
        $('.route_places .sortable').append('<li class="custome-li"  >'
                + '<input type="hidden" class="customer_type"name="customer_type[]" value="Customer">'
                + '<input type="hidden" class="selected_place" name="customer_id[]" value="' + customer_id + '">'
                + '<input type="hidden" class="selected_place" name="place[]" value="' + customer_name + '">'
                + '<input type="hidden" class="place_address" name="place_address[]" value="' + area + ',' + location + '">'
                + '<input type="hidden" class="place_lat" name="place_lat[]" value="">'
                + '<input type="hidden" class="place_lng" name="place_lng[]" value="">'
                + '<label>' + customer_name + '</label>'
                + '<div>' + area + ',' + location + '</div>'
                + '<span  class="closeList pull-right">X</span></li>');

    });
    calculateAndDisplayRoute(directionsService, directionsDisplay);
    $('#storeMaster').slideUp();
    $('.checkboxStore:checked').each(function () {
        $(this).prop('checked', false);
    });
}
function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    var waypts = [];
    var checkboxArray = [];
    var lat;
    var lng;
    var j = 1;
    var f;
    $('#route li').each(function (i, e)    {
       checkboxArray.push($(this).find(".place_address").val()); // This is your rel value
        var address = $(this).find(".place_address").val();
        var geocoder = new google.maps.Geocoder();
        var place = $(this).find(".selected_place").val();
        var place_lat = $(this).find(".place_lat").val();
        var place_lng = $(this).find(".place_lng").val();
        if (geocoder) {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                console.log(results, status);
                if (status == "OK") {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    $(this).find('.place_lat').val(lat);
                    $(this).find('.place_lng').val(lng);
                }
            });
        }
    });

    for (var i = 0; i < checkboxArray.length; i++) {
        waypts.push({
            location: checkboxArray[i],
            stopover: true
        });
    }

    directionsService.route({
        origin: $("input[name=starting_location]").val(),
        destination: $('.route_places li').last().find('.place_address').val(),
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: 'DRIVING'
    }, function (response, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            for (var i = 0; i < route.legs.length - 1; i++) {
                var routeSegment = i + 1;
            }
        } else {
            f = 1;
            window.alert('Directions request failed due to ' + status);
        }
    });
    return f;
}

