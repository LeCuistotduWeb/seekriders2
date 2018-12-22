(function() {
    var placesAutocomplete = places({
        appId: 'plEON2OM6ISI',
        apiKey: 'a2b925736823f0cf3a776a6602f2b27e',
        container: document.querySelector('#account_location_address'),
        templates: {
            value: function(suggestion) {
                return suggestion.name;
            }
        }
    }).configure({
        type: 'address'
    });
    placesAutocomplete.on('change', function resultSelected(e) {
        document.querySelector('#account_location_country').value = e.suggestion.country || '';
        document.querySelector('#account_location_region').value = e.suggestion.administrative || '';
        document.querySelector('#account_location_department').value = e.suggestion.county || '';
        document.querySelector('#account_location_city').value = e.suggestion.city || '';
        document.querySelector('#account_location_postCode').value = e.suggestion.postcode || '';
        document.querySelector('#account_location_longitude').value = e.suggestion.latlng.lng|| '';
        document.querySelector('#account_location_latitude').value = e.suggestion.latlng.lat || '';
    });
})();