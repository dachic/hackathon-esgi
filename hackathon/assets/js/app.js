require('../css/app.scss');


var mapboxgl = require('mapbox-gl/dist/mapbox-gl.js');

mapboxgl.accessToken = 'pk.eyJ1IjoiZGJlbGFyb3Vzc2kiLCJhIjoiY2p0Zm5ncGJoMGZzMTQ5bXgxMWgzbm41cSJ9.HKWsMtjl7JwpBGXMmfuqdQ';
var map = new mapboxgl.Map({
    container: 'container',
    style: 'mapbox://styles/mapbox/streets-v11'
});

