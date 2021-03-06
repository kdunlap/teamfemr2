class VisitedLocation{

    constructor() {

        this.reset();
    }

    reset() {

        this.uniqueId = _.uniqueId();

        this.id = '';
        this.address = '';
        this.addressExt = '';
        this.locality = '';
        this.administrativeAreaLevel1 = '';
        this.administrativeAreaLevel2 = '';
        this.cityStateCountry = '';
        this.postalCode = '';
        this.country = '';

        this.latitude = 0.0;
        this.longitude = 0.0;
        this.position = {

            lat: 0.0,
            lng: 0.0
        };
    }

    populate( location ){

        this.id = location.id;
        this.address = location.address;
        this.addressExt = location.addressExt;
        this.locality = location.locality;
        this.administrativeAreaLevel1 = location.administrativeAreaLevel1;
        this.administrativeAreaLevel2 = location.administrativeAreaLevel2;
        this.cityStateCountry = location.cityStateCountry;
        this.postalCode = location.postalCode;
        this.country = location.country;

        this.latitude = parseFloat( location.latitude );
        this.longitude = parseFloat( location.longitude );

        this.position = {

            lat: this.latitude,
            lng: this.longitude
        };
    }

    populateFromPlace( place ){

        // do nothing is place does not have an address
        if( ! _.has( place, [ 'geometry', 'location' ] ) ) return;

        var components = {};
        for (var i = 0; i < place.address_components.length; i++) {

            var c = place.address_components[i];
            components[c.types[0]] = c;
        }

        // Reset fields so previous info is not left behind
        this.reset();

        if ( _.has( components, 'street_number' ) ) {

            this.address = components.street_number.long_name + ' '
        }

        if ( _.has( components, 'route' ) ){

            this.address += components.route.long_name;
        }

        if ( _.has( components, 'subpremise' ) ){

            this.addressExt = components.subpremise.long_name;
        }

        if ( _.has( components, 'locality' ) ){

            this.locality = components.locality.long_name;
        }

        if ( _.has( components, 'administrative_area_level_1' ) ){

            this.administrativeAreaLevel1 = components.administrative_area_level_1.short_name;
        }

        if ( _.has( components, 'postal_code' ) ){

            this.postalCode = components.postal_code.long_name;
        }

        if ( _.has( components, 'country' ) ){

            this.country = components.country.long_name;
        }

        if ( _.has( place, [ 'geometry', 'location' ] ) ){

            this.latitude = parseFloat( place.geometry.location.lat().toFixed( 5 ) );
            this.longitude = parseFloat( place.geometry.location.lng().toFixed( 5 ) );

            this.position = {

                lat: this.latitude,
                lng: this.longitude
            };
        }
    }

    post() {

        return {

            "id": this.id,
            "address": this.address || "",
            "address_ext": this.addressExt || "",
            "locality": this.locality || "",
            "administrative_area_level_1": this.administrativeAreaLevel1 || "",
            "administrative_area_level_2": this.administrativeAreaLevel2 || "",
            "postal_code": this.postalCode || "",
            "country": this.country || "",
            "latitude": this.latitude || "",
            "longitude": this.longitude || ""
        }
    }

    store() {

        return {

            "id": this.id,
            "address": this.address || "",
            "addressExt": this.addressExt || "",
            "locality": this.locality || "",
            "administrativeAreaLevel1": this.administrativeAreaLevel1 || "",
            "administrativeAreaLevel2": this.administrativeAreaLevel2 || "",
            "postalCode": this.postalCode || "",
            "country": this.country || "",
            "latitude": this.latitude || "",
            "longitude": this.longitude || ""
        }
    }


    hasPosition( m ) {

        return ( this.latitude !== 0.0 ) && ( this.longitude !== 0.0 );
    }

    shortAddress() {

        let address = '';

        if( this.locality.length > 0 )
        {
            address += this.locality;
        }

        if( this.administrativeAreaLevel1.length > 0 )
        {
            if( address.length > 0 ) address += ', ';

            address += this.administrativeAreaLevel1;
        }

        if( this.country.length > 0 )
        {
            address += '<br />' + this.country;
        }

        return address;
    }
}

export default VisitedLocation;