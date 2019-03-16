import Places from 'places.js';

// (function() {
//     let placesAutocomplete = places({
//         appId: 'plEON2OM6ISI',
//         apiKey: 'a2b925736823f0cf3a776a6602f2b27e',
//         container: document.querySelector('.js-address'),
//         templates: {
//             value: function(suggestion) {
//                 return suggestion.name;
//             }
//         }
//     }).configure({
//         type: 'address'
//     });
//
//     placesAutocomplete.on('change', function resultSelected(e) {
//         console.log(e);
//         document.querySelector('.js-address').value = e.suggestion.name || '';
//         document.querySelector('.js-country').value = e.suggestion.country || '';
//         document.querySelector('.js-region').value = e.suggestion.administrative || '';
//         document.querySelector('.js-department').value = e.suggestion.county || '';
//         document.querySelector('.js-city').value = e.suggestion.city || '';
//         document.querySelector('.js-postcode').value = e.suggestion.postcode || '';
//         document.querySelector('.js-lng').value = e.suggestion.latlng.lng || '';
//         document.querySelector('.js-lat').value = e.suggestion.latlng.lat || '';
//     });
// })();

let appId = 'plEON2OM6ISI'
let apikey = 'a2b925736823f0cf3a776a6602f2b27e'

let inputAddress = document.querySelector('.js-address')
if (inputAddress !== null) {
    let place = Places({
        appId: appId,
        apiKey: apikey,
        container: inputAddress,
    })
    place.on('change', e =>{
        document.querySelector('.js-address').value = e.suggestion.name || '';
        document.querySelector('.js-country').value = e.suggestion.country || '';
        document.querySelector('.js-region').value = e.suggestion.administrative || '';
        document.querySelector('.js-department').value = e.suggestion.county || '';
        document.querySelector('.js-city').value = e.suggestion.city || '';
        document.querySelector('.js-postcode').value = e.suggestion.postcode || '';
        document.querySelector('.js-lng').value = e.suggestion.latlng.lng || '';
        document.querySelector('.js-lat').value = e.suggestion.latlng.lat || '';
    })
}

let searchAddress = document.querySelector('#spot_search_address')
if (searchAddress !== null) {
    let place = Places({
        appId: appId,
        apiKey: apikey,
        container: searchAddress,
    })
    place.on('change', e =>{
        document.querySelector('#spot_search_address').value = e.suggestion.name || '';
        document.querySelector('#spot_search_lat').value = e.suggestion.latlng.lat || '';
        document.querySelector('#spot_search_lng').value = e.suggestion.latlng.lng || '';
    })
}