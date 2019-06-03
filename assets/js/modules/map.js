import L from 'leaflet';
import 'leaflet/dist/leaflet.css'
import 'leaflet.locatecontrol'
import 'leaflet.markercluster'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import axios from 'axios'

export default class Map {

    // Init the map
    static init() {
        let map = document.querySelector('#map');

        if (map === null) {
            return
        }

        function getCenterMap(){
            //Center of the map
            let center;
            if(map.dataset.lat === undefined || map.dataset.lng === undefined){
                return center = [47.83769, 7.625492];
            }else{
                return center = [map.dataset.lat, map.dataset.lng];
            }
        }

        map = L.map('map').setView(getCenterMap(), 6);
        L.tileLayer('https://Api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: ' ',
            maxZoom: 18,
            minZoom: 2,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGVjdWlzdG90ZHV3ZWIiLCJhIjoiY2ptcTVxa3p0MW1odTNwanBtdjd6Z2g1dyJ9.MEAlNrofdb89_X_BRuLqVw'
        }).addTo(map);

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

        //Create a marker
        // L.marker(center, {icon: skateparkIcon}).addTo(map);

        const url = "/spot/api/all";
        axios.get(url)
            .then(function (response) {
                for (let spot of response.data) {
                    addMarker(spot)
                }
            })

        // Add marker clusterer
        let markers = L.markerClusterGroup();

        function addMarker(spot){
            let icon;
            spot.type === 0 ? icon = streetIcon : icon = skateparkIcon;
            let marker = L.marker([spot.location.latitude, spot.location.longitude], {
                icon : icon,
                title: spot.title,
                riseOnHover: true
            }).addTo(map).bindPopup(
                `<div>
                    <a href="/spot/${ spot.id }">
                    <img class="img-fluid" src="/images/spots/image-null.jpg" alt="image/photo du spot ${ spot.title }">
                    </a>
                    <p>${spot.title}</p>
                 </div>
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
    }
}