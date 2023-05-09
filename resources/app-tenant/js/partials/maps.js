/** @return {object} default google map configuration */
function googleMapsDefaultConf()
{
    return {
        zoom: 16,
        backgroundColor: 'none',
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER,
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_BOTTOM,
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP,
        },
        fullscreenControl: true,
        styles: [{
            elementType: "labels.icon",
            stylers: [{
                visibility: "off"
            }]
        }, ],
    };
}

/** @return {object} night google map configuration */
function googleMapsNightConf()
{
    let conf = googleMapsDefaultConf();
    conf.styles = [{
        elementType: "geometry",
        stylers: [{
            color: "#dddddd"
        }]
    },
    {
        elementType: "labels.icon",
        stylers: [{
            visibility: "off"
        }]
    },
    {
        elementType: "labels.text.fill",
        stylers: [{
            color: "#616161"
        }]
    },
    {
        elementType: "labels.text.stroke",
        stylers: [{
            color: "#f5f5f5"
        }]
    },
    {
        featureType: "administrative.land_parcel",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#bdbdbd"
        }]
    },
    {
        featureType: "poi",
        stylers: [{
            visibility: "off"
        }]
    },
    {
        featureType: "poi",
        elementType: "geometry",
        stylers: [{
            color: "#eeeeee"
        }]
    },
    {
        featureType: "poi",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#757575"
        }]
    },
    {
        featureType: "poi.park",
        elementType: "geometry",
        stylers: [{
            color: "#e5e5e5"
        }]
    },
    {
        featureType: "poi.park",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#9e9e9e"
        }]
    },
    {
        featureType: "road",
        elementType: "geometry",
        stylers: [{
            color: "#ffffff"
        }]
    },
    {
        featureType: "road.arterial",
        stylers: [{
            color: "#2a3042"
        }]
    },
    {
        featureType: "road.arterial",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#ffffff"
        }]
    },
    {
        featureType: "road.highway",
        elementType: "geometry",
        stylers: [{
            color: "#dadada"
        }]
    },
    {
        featureType: "road.highway",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#616161"
        }]
    },
    {
        featureType: "road.local",
        stylers: [{
            color: "#696e7a"
        }]
    },
    {
        featureType: "road.local",
        elementType: "labels.text",
        stylers: [{
            color: "#ffffff"
        }]
    },
    {
        featureType: "road.local",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#2a3042"
        }]
    },
    {
        featureType: "transit.line",
        elementType: "geometry",
        stylers: [{
            color: "#e5e5e5"
        }]
    },
    {
        featureType: "transit.station",
        elementType: "geometry",
        stylers: [{
            color: "#eeeeee"
        }]
    },
    {
        featureType: "water",
        elementType: "geometry",
        stylers: [{
            color: "#ffffff"
        }]
    },
    {
        featureType: "water",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#9e9e9e"
        }]
    }];

    return conf;
}

/**
 * 
 * @param {string} type of the line
 * @param {string} color of the line
 * @returns {array}
 */
function getPolylineIcons(type, color) {
    let path;

    if (type == 'dashed') {
        path = "M 0,-1 0,1";

    } else if (type == 'dotted') {
        path = "M 0,-1 0,-1";   
    }

    return [{
        icon: {
            path: path,
            strokeOpacity: 1,
            strokeColor: color,
            scale: 3,
        },
        offset: "0",
        repeat: "10px",
    }, ];
}