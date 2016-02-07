$(document).ready(function() {

var x = 0;
var y = 0;
var banner = $(".banner");

banner.css('backgroundPosition', x + 'px' + ' ' + y + 'px');

window.setInterval(function() {
	banner.css("backgroundPosition", x + 'px' + ' ' + y + 'px');
	y--;
}, 90)
});






$(function () {
	    $('#openCategories').click( function () {
	        $('#sidebar-wrapper').slideToggle();
	        $('.sidebar-nav').slideToggle();
	    });
	});


$('.dropdown-toggle').click(function() {
  $(this).next('.dropdown-menu').slideToggle(500);
});



