const axios = require('axios');
$('.dot:nth-child(1)').click(function(){
$('.inside').animate({
    'width' : '10%'
}, 500);
});
$('.dot:nth-child(2)').click(function(){
    $('.inside').animate({
    'width' : '30%'
    }, 500);
});
$('.dot:nth-child(3)').click(function(){
    $('.inside').animate({
    'width' : '50%'
    }, 500);
});
$('.dot:nth-child(4)').click(function(){
    $('.inside').animate({
    'width' : '70%'
    }, 500);
});
$('.dot:nth-child(5)').click(function(){
    $('.inside').animate({
    'width' : '90%'
    }, 500);
});

$('.dot').click(function(e)
{
    $("#timeline").children().removeClass("color-circle");
    let date = $(this).children().eq(1).html();
    sessionStorage.setItem("date", date);
    getData();
    $(this).addClass("color-circle");
});

$(document).on("click", ".cat-img", function(e) 
{   $("#timeline").children().css('opacity', '0.5');
    sessionStorage.setItem("cat_id", e.currentTarget.id);
    getData();
    $(this).css('opacity', '1');
});

$( document ).ready(function() {
    result = getData();
    
    results = {};
    function getData()
    {
        if (sessionStorage.getItem("cat_id")) 
        {
            cat = sessionStorage.getItem("cat_id");
        }
        else 
        {
            cat = "17";
        }
        if(sessionStorage.getItem("date"))
        {
            date = sessionStorage.getItem("date");
        } 
        else {
            date = 2018;
        }
        number = parseInt(date) ;
        annee2 = number + 1 ;
        date2 = annee2 + "0101";
        date = date + "0101_" + date2 ;

        results = {};
        // Get data from controller
        axios.get('https://localhost/articles/year/{PERIOD}/category/{CATEGORY}'.replace('{PERIOD}', date).replace('{CATEGORY}', cat))
        .then(function (response) {
            results = response.data;
            loadMap(results);
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
        // always executed
        
        }); 
        return results;  
    }

});

function loadMap(articles)
{console.log(articles);
    google.charts.load('current', {
        'packages': ['geochart'],
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });
    google.charts.setOnLoadCallback(drawRegionsMap);
    
    function drawRegionsMap() {

        var table = [['Pays', "Nombre d'articles"]];
        for (var i in articles) {
            table.push([i,articles[i].score]);
        };
        console.log(table);
        var data = google.visualization.arrayToDataTable(table);
    
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
}
