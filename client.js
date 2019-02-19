function getCositas(){
    var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
            pintaTablaMarcas(this.responseText);
		}else{
			console.log(this.readyState + " " + this.status);
		}
	};

	xhttp.open("GET", "post.php", true);
	xhttp.send();
}

function annadirCositas(vuelo){
  //(:diayhora, :origen, :destino, :precio, :plazas_totales, :plazas_libres)
    
}

function borrarCositas(id) {

    peticion.peticion = "remove";
    peticion.idVuelo = id;

    console.log(peticion);

    peticionJSON = JSON.stringify(peticion);

    console.log(peticionJSON);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("DELETE", "posts.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    //document.getElementById("boton").disabled = true;
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var respuestaJSON = JSON.parse(this.responseText);

            //if (respuestaJSON["estado"] == "ok") {
                return true
            //} else {
            //  return false
            //}

        } else {
            return false
        }
    }
}
