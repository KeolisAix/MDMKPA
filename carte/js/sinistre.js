var sinistre;
var map;
var sinistres = [];
var infowindowSinistre = new google.maps.InfoWindow({ maxWidth: 320 });

function addsinistre(location, title) {
    sinistre = new google.maps.Marker({
        position: location,
        map: map,
        title: title,
        bus: "118218",
        dateS: "00/00/0000",
        dateD: "11/11/1111",
        controleur: "Willy BOISFER"
    });
    sinistres.push(sinistre);
    google.maps.event.addListener(sinistre, 'click', function () {
        var bulle = "<img src='http://192.168.207.125/sinistre/photo_sinistre/files/20150127_090046.jpg'  width='300' height='120'  id='ok' style='overflow:auto; border:solid 1px black;'></img><center><br>SINISTRE :<br>";
        infowindowSinistre.setContent(bulle+" "+this.title+"<br>BUS: "+this.bus+"<br>Date Sinistre: "+this.dateS+"<br>Date Déclaration: "+this.dateD+"<br>Contrôleur: "+this.controleur+"</center>");
        infowindowSinistre.open(this.getMap(), this);
    });
}
function setAllMapSinistre(map) {
    for (var i = 0; i < sinistres.length; i++) {
        sinistres[i].setMap(map);
    }
}

// Removes the arrets from the map, but keeps them in the array.
function clearSinistre() {
    setAllMapSinistre(null);
}

// Shows any arrets currently in the array.
function showSinistre() {
    setAllMapSinistre(map);
}
