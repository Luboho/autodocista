<template>

    <GMap
    ref="gMap"
    language="en"
    :cluster="{options: {styles: clusterStyle}}"
    :center="{lat: locations[0].lat, lng: locations[0].lng}"
    :options="{fullscreenControl: false, styles: mapStyle}"
    :zoom="6"
    >
    <GMapMarker
        v-for="location in locations"
        :key="location.id"
        :position="{lat: location.lat, lng: location.lng}"
        :options="{icon: location === currentLocation ? pins.selected : pins.notSelected}"
        @click="currentLocation = location"
    >
        <GMapInfoWindow :options="{maxWidth: 200}">
        <code>
            lat: {{ location.lat }},
            lng: {{ location.lng }}
        </code>
        </GMapInfoWindow>
    </GMapMarker>
    <GMapCircle :options="circleOptions"/>
    </GMap>

</template>

<script>
    export default {
        name: "locations",
        head: {
            title: "Nájdete nás"
        },
        data() {
            return {
                currentLocation: {},
                circleOptions: {
                // ...
                },
                locations: [
                {
                    lat: 48.8039283,
                    lng: 20.6689382
                },
                {
                    lat: 45.815,
                    lng: "15.9819"
                },
                {
                    lat: "45.12",
                    lng: "16.21"
                }
                ],
                pins: {
                selected: "data:image/png;base64,iVBORw0KGgo...",
                notSelected: "data:image/png;base64,iVBORw0KGgo..."
                },
                // mapStyle: [...],
                clusterStyle: [
                {
                    url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png",
                    width: 56,
                    height: 56,
                    textColor: "#fff"
                }
                ]
            }
            }   
    }
</script>   