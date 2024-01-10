var placeSearch, autocomplete;
var componentForm = {
	street_number: 'long_name',
	route: 'long_name',
	locality: 'long_name',
	administrative_area_level_1: 'long_name',
	country: 'long_name',
	postal_code: 'short_name'
};

function initAutocomplete() {
	autocomplete = new google.maps.places.Autocomplete(
		(document.getElementById('address')),
		{types: ['geocode']}
		);

	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	var place = autocomplete.getPlace();

	for (var component in componentForm) {
		if (document.getElementById(addressType) != undefined && document.getElementById(addressType)) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		}
	}

	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
			var val = place.address_components[i][componentForm[addressType]];
			if (document.getElementById(addressType) != undefined && document.getElementById(addressType)) {
				document.getElementById(addressType).value = val;
			}
		}
	}
}

function geolocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position
			});
			document.getElementById('latitude').value = position.coords.latitude;
			document.getElementById('longitude').value = position.coords.longitude;
			autocomplete.setBounds(circle.getBounds());
		});
	}
}
