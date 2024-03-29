import L from 'leaflet';
import 'leaflet.locatecontrol'
import 'leaflet.markercluster'
import 'leaflet-search'
import axios from 'axios'

export default class Map {
    // Init the map
    static init() {
        let spots= [];
        let map = document.querySelector('#map');
        let center = [47.83769, 7.625492];
        // Icon skatepark
        let skateparkIcon = L.icon({
            iconUrl: '/images/icons/icon-skatepark-min.png',
            iconSize: [45, 55], // size of the icon
            iconAnchor: [25, 80], // point of the icon which will correspond to marker's location
            popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        // Icon street
        let streetIcon = L.icon({
            iconUrl: '/images/icons/icon-street-min.png',
            iconSize: [45, 55], // size of the icon
            iconAnchor: [25, 60], // point of the icon which will correspond to marker's location
            popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        if (map === null) {
            return
        }

        map = L.map('map').setView(center, 6);
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            attribution: ' ',
            maxZoom: 18,
            minZoom: 2,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGVjdWlzdG90ZHV3ZWIiLCJhIjoiY2ptcTVxa3p0MW1odTNwanBtdjd6Z2g1dyJ9.MEAlNrofdb89_X_BRuLqVw'
        }).addTo(map);

        // Add marker clusterer
        let markers = L.markerClusterGroup();

        (function getMarkers(){
            let spot = document.getElementById("map").dataset.spot;
            if(spot){
                spot = JSON.parse(spot);
                map.setView([spot.location.latitude, spot.location.longitude], 12);
                addMarker(spot);
            }else {
                axios('/api/spots/',{
                    method: 'POST'
                }).then(function (response) {
                    spots = response.data;
                    for(spot of response.data){
                        addMarker(spot);
                    }
                })
            }
        })();

        function addMarker(spot){
            let icon;
            let spotImg;
            if(spot.spot_image != null){
                spotImg = `${spot.spot_image}`
            }else{
                spotImg = 'image-null.jpg'
            }
            spot.type === 0 ? icon = streetIcon : icon = skateparkIcon;
            let marker = L.marker([spot.location.latitude, spot.location.longitude], {
                icon : icon,
                title: spot.title,
                riseOnHover: true
            }).addTo(map).bindPopup(
                `
                <a href="/spot/${ spot.id }">
                <img class="img-fluid" src="/images/spots/${spotImg}" alt="image/photo du spot ${ spot.title }">
                </a>
                <p>${spot.title}</p>
            `);
            markers.addLayer(marker);
        }
        map.addLayer(markers);

        // // Add button locate my position
        let lc = L.control.locate().addTo(map);

        // Locate my position
        function getLocatePositionBtn(){
            lc.start ();
        }

        let controlSearch = new L.Control.Search({
            position:'topleft',
            layer: markers,
            zoom: 12,
        });

        map.addControl( controlSearch );
    }
}
