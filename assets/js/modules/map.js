import L from 'leaflet';
import 'leaflet/dist/leaflet.css'

export default class Map {
    static init(){
        let map = document.querySelector('#map')

        if(map === null){
            return
        }

        let center = [map.dataset.lat, map.dataset.lng]

        map = L.map('map').setView(center, 14)
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: ' ',
            maxZoom: 18,
            minZoom: 2,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGVjdWlzdG90ZHV3ZWIiLCJhIjoiY2ptcTVxa3p0MW1odTNwanBtdjd6Z2g1dyJ9.MEAlNrofdb89_X_BRuLqVw'
        }).addTo(map)
        L.marker(center).addTo(map);

    }
}