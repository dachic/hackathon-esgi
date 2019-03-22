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
{ 
    sessionStorage.setItem("cat_id", e.currentTarget.id);
    getData();
});

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

    console.log(cat + date);
    // Get data from controller
    axios.get('https://localhost/articles/year/{PERIOD}/category/{CATEGORY}'.replace('{PERIOD}', date).replace('{CATEGORY}', cat))
    .then(function (response) {
        console.log(response.data);
    })
    .catch(function (error) {
        console.log(error);
    })
    .then(function () {
    // always executed
    }); 
        
}

$( document ).ready(function() {
    if(sessionStorage.getItem("cat_id"))
    {
        var cat = sessionStorage.getItem("cat_id");
    }
    else
        cat = "17";
});
