import $script from "scriptjs";

let $map = document.querySelector('#map');

$script('https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFCS7qB1q0v_L-XeplU1ClqQzUS2WF5g&callback=initMap', function () {
    class GoogleMap {
        // Initialize and add the map
        load(element) {

            let center = {lat: 48.4457, lng: 1.52602};
            // The map, centered at Uluru
            let map = new google.maps.Map(element, {
                zoom: 8,
                center: center
            });
            // The marker, positioned at Uluru
            // var marker = new google.maps.Marker({position: uluru, map: map});
        }
    }

    if($map != null){
        let map = new GoogleMap();
        map.load($map);
    }
});