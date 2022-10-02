function showLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $("#lat").val(latitude);
    $("#lon").val(longitude);
    console.log("Latitude is "+latitude);
    var latlongvalue = position.coords.latitude + ","
    + position.coords.longitude;
    var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
    +latlongvalue+"&zoom=14&size=400x300&key=AIzaSyAa8HeLH2lQMbPeOiMlM9D1VxZ7pbGQq8o";
    //document.getElementById("mapholder").innerHTML="<iframe width='400' height='250' src='"+img_url+"' frameborder='0' style='border:0' allowfullscreen></iframe>";
    //document.getElementById("mapholder").src=img_url;
 }
 function errorHandler(err) {
    if(err.code == 1) {
       alert("Error: Access is denied!");
    } else if( err.code == 2) {
       alert("Error: Position is unavailable!");
    }
 }
 function getLocation(){
    if(navigator.geolocation){
       // timeout at 60000 milliseconds (60 seconds)
       var options = {timeout:60000};
       navigator.geolocation.getCurrentPosition
       (showLocation, errorHandler, options);
    } else{
       alert("Sorry, browser does not support geolocation!");
    }
 }

 function setLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $("#latitude").val(latitude);
    $("#longitude").val(longitude);
    console.log("Latitude is "+latitude);
    var latlongvalue = position.coords.latitude + ","
    + position.coords.longitude;
    var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
    +latlongvalue+"&zoom=14&size=400x300&key=AIzaSyAa8HeLH2lQMbPeOiMlM9D1VxZ7pbGQq8o";
    document.getElementById("mapholder").innerHTML =
    "<iframe width='400' height='250' src='"+img_url+"' frameborder='0' style='border:0' allowfullscreen></iframe>";
    document.getElementById("mapholder").src=img_url;
 }

 function location_set()
 {
    navigator.geolocation.getCurrentPosition(setLocation);
 }

window.onload=getLocation();
$("body").on("click", "#set_location", location_set);
