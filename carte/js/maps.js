        var arret;
        var map;
        var arrets = [];
        var infowindow = new google.maps.InfoWindow();
        
        function initialize() {
            var haightAshbury = new google.maps.LatLng(43.526859, 5.444245);
            var myStyle = [
                  {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                      { "visibility": "off" }
                    ]
                  }
                ];
            var mapOptions = {
                zoom: 12,
                center: haightAshbury,
                mapTypeIds: ['mystyle', 'mystyle', 'mystyle'],
                mapTypeId: 'mystyle'
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);
              map.setTilt(45);
              map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, { name: 'My Style' }));
        }

        // Add a arret to the map and push to the array.
        function addarret(location, title) {
            arret = new google.maps.Marker({
                position: location,
                map: map,
                icon: "https://maps.google.com/mapfiles/kml/shapes/schools_maps.png",
                title: title
            });
            arrets.push(arret);
            google.maps.event.addListener(arret, 'click', function () {
                var bulle = "<center>ARRET :<br>";
                infowindow.setContent(bulle+" "+this.title+"</center>");
                infowindow.open(this.getMap(), this);
            });
        }

        function addSinistre(location, title) {
            sinistre = new google.maps.Marker({
                position: location,
                map: map,
                icon: "https://maps.google.com/mapfiles/kml/shapes/caution.png",
                title: title
            });
            arrets.push(sinistre);

            google.maps.event.addListener(sinistre, 'click', function () {
                var bulleSinistre = "<center>SINISTRE :<br>";
                infowindow.setContent(bulleSinistre+" "+this.title+"</center>");
                infowindow.open(this.getMap(), this);
            });
        }

        // Sets the map on all arrets in the array.
        function setAllMap(map) {
            for (var i = 0; i < arrets.length; i++) {
                arrets[i].setMap(map);
            }
        }

        // Removes the arrets from the map, but keeps them in the array.
        function clearArrets() {
            setAllMap(null);
        }

        // Shows any arrets currently in the array.
        function showArrets() {
            setAllMap(map);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
