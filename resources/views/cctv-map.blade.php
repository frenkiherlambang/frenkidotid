<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 100vh;
        }
    </style>
</head>

<body>

    <div id="map"></div>
    <script>
        var map = L.map('map').setView([-7.800119, 110.370026], 11);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // L.marker([-7.800119, 110.370026]).addTo(map)
        //     .bindPopup("<img src='https://picsum.photos/300/200' width='400'>", {
        //         maxWidth: 560
        //     });

        L.marker([-7.782751, 110.366982]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_22/Tugu1.jpg' width='400'>", {
                maxWidth: 560
            }); // Tugu1
        L.marker([-7.782953, 110.367181]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_22/Tugu2.jpg' width='400'>", {
                maxWidth: 560
            }); // Tugu2
        L.marker([-7.78708, 110.378593]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_19/UKDW.jpg' width='400'>", {
                maxWidth: 560
            }); // Tugu2


            L.marker([-7.782905, 110.374857]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_19/Gramedia.jpg' width='400'>", {
                maxWidth: 560
            }); //


            L.marker([-7.801356, 110.364850]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_19/KMNol.jpg' width='400'>", {
                maxWidth: 560
            }); //

            L.marker([-7.799629, 110.364813]).addTo(map)
            .bindPopup("<img src='https://bucket.frenki.id/capture/2023-10-20_19/UPTMalio24_SimpangReksobayan.jpg' width='400'>", {
                maxWidth: 560
            }); //


        map.on('click', onMapClick);

        function onMapClick(e) {
            alert("You clicked the map at " + e.latlng);
        }
    </script>
</body>

</html>
