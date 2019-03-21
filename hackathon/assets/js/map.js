google.charts.load('current', {
    'packages': ['geochart'],
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
 });
 google.charts.setOnLoadCallback(drawRegionsMap);
 
 function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
        ['Pays', "<button>TEST</button>"],
        ['Germany', 200],
        ['Greece', 300],
        ['Poland', 400],
        ['Italy', 500],
        ['France', 600],
        ['RUSSIA', 700],
        ['Sweden', 1000],
 
    ]);
 
    var options = {
        region: '150',
        colorAxis: {colors: ['#4c5e57', '#4d7565', '#628450' , '#8e7b30', '#9b6e2b', "#7c5213"]},
        backgroundColor: {"fill" : "#232323" , "stroke" : "#232323", "strokeWidth" : 0},
        magnifyingGlass : {zoomFactor:1},
        datalessRegionColor: '#4a544f',
        defaultColor: '#4a544f',
        keepAspectRatio: true,
        legend: 'none',
 
    };
 
    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
 
    chart.draw(data, options);
 }
