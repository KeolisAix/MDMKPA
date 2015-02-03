var sinistre;
var map;
var sinistres = [];
var infowindowSinistre = new google.maps.InfoWindow({ maxWidth: 320 });

function addsinistre(location, title, bus, dateSinistre, dateDeclaration, controleur, photo) {
    sinistre = new google.maps.Marker({
        position: location,
        map: map,
        title: title,
        bus: bus,
        dateS: dateSinistre,
        dateD: dateDeclaration,
        controleur: controleur,
        photo: photo
    });
    sinistres.push(sinistre);
    google.maps.event.addListener(sinistre, 'click', function () {
        if (photo == "NO") {
            var bulle = "<img src='http://www.ats-sport.com/h/images_typeepreuve/pas-de-photo.png'  width='300' height='120'  id='ok' style='overflow:auto; border:solid 1px black;'></img><center><br>SINISTRE :<br>";
        } else {
            var bulle = "<img src='http://192.168.207.125/sinistre/photo_sinistre/files/" + this.photo + "'  width='300' height='120'  id='ok' style='overflow:auto; border:solid 1px black;'></img><center><br>SINISTRE :<br>";
        }
        infowindowSinistre.setContent(bulle + " " + this.title + "<br>BUS: " + this.bus + "<br>Date Sinistre: " + this.dateS + "<br>Date D&eacute;claration: " + this.dateD + "<br>Contr&ocirc;leur: " + this.controleur + "</center>");
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
