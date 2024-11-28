
function showtrip(str) {
    if (str.length == 0) {
        document.getElementById("result").innerHTML = "No trip Found"
        return;
    }
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("result").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "fliterTrip.php?dname="+ str, true);
        xmlhttp.send();
}

function sendRequest(tripID) {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("requestStatus").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "./sendRequest.php?tripID=" + tripID, true);
        xmlhttp.send();
    }

function filterLocation(loc) {
    console.log(loc);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("result").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./filterByLocation.php?loc="+loc, true);
    xmlhttp.send();
}