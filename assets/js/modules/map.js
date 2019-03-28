import L from 'leaflet';
import 'leaflet/dist/leaflet.css'
import 'leaflet.locatecontrol'
import 'leaflet.markercluster'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'


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
                return center = [48.853796, 2.352402];
            }else{
                return center = [map.dataset.lat, map.dataset.lng];
            }
        }

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

        map = L.map('map').setView(getCenterMap(), 6);
        L.tileLayer('https://Api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: ' ',
            maxZoom: 18,
            minZoom: 2,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGVjdWlzdG90ZHV3ZWIiLCJhIjoiY2ptcTVxa3p0MW1odTNwanBtdjd6Z2g1dyJ9.MEAlNrofdb89_X_BRuLqVw'
        }).addTo(map);

        //Create a marker
        // L.marker(center, {icon: skateparkIcon}).addTo(map);

        // Add marker clusterer
        let markers = L.markerClusterGroup();

        Array.from(document.querySelectorAll('.leaflet-marker')).forEach((item) => {
            let icon;
            if(item.dataset.type === '1'){
               icon = skateparkIcon;
            }
            else if (item.dataset.type === '0'){
               icon = streetIcon;
            }
            else {
                icon = skateparkIcon;
            }
            let marker = L.marker([item.dataset.lat, item.dataset.lng], {icon: icon}).addTo(map);
            markers.addLayer(marker);
        });
        map.addLayer(markers);

        // // Add button locate my position
        let lc = L.control.locate().addTo(map);

        // Locate my position
        function getLocatePositionBtn(){
            lc.start ();
        }
    }
}