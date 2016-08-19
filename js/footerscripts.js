//put scripts to run just before closing body tag here. Will be loade by wp_footer()

//google map for contact page ----------------------------------------------------//


function initialize() {
    
//var latlong = new google.maps.LatLng(53.80583, -1.548903);
var latlong = new google.maps.LatLng(footer_data.googlemap_lat, footer_data.googlemap_long);

//var firstLatlng = new google.maps.LatLng(53.80583, -1.548903);
var firstLatlng = new google.maps.LatLng(footer_data.googlemap_lat, footer_data.googlemap_long); 

var firstOptions = {
    zoom: 16,
    center: firstLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP 
};

var map = new google.maps.Map(document.getElementById("map_leeds"), firstOptions);

firstmarker = new google.maps.Marker({
    map:map,
    draggable:false,
    animation: google.maps.Animation.DROP,
    title: 'Our Company',
    position: latlong
});

//the address passed in from our options
var contentString1 = footer_data.googlemap_address;


var infowindow1 = new google.maps.InfoWindow({
    content: contentString1
});

google.maps.event.addListener(firstmarker, 'click', function() {
    infowindow1.open(map,firstmarker);
});

}