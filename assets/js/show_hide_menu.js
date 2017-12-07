////// POUR LA SIDE BARRE EN PETIT //////////////


$( document ).ready(function() {
	//$('.navbar-brand img').css({'margin':'-59px 0 0 41px'});
	width_screen();
});

$( window ).resize(function() {
width_screen();
});

function width_screen() {

	if($(window).width()<768) {
		//$('#handle').css({'display':'none'});
		$i=0;
		init_smartph();
    } else {
    	$i=1;
    	$('#handle').css({'display':'block'});
    	$('#toggle-fullscreen').css({'display':'inline'});
         if($(window).width()<1281) {
            fermeture_menu();
        } else {
            ouverture_menu();
        }

   }
}

function fermeture_menu() {
	$('.sidebar').css({'width': ' 36px'});
	$('#page-wrapper').css({'margin' :'0 0 0 37px'});
	$('.tit_disp').css({'display':'none'});
	$('.sidebar .arrow').css({'display':'none'});
	$('#reduire_menu').css({'display':'none'});
	$('.sidebar-bonjour').css({'display':'none'});
	$('#side-menu>li>a').css({'padding': ' 9px 9px'});
	$('.navbar-brand img').css({'margin' : '-23px 0 0 10px'});
	$('#side-menu .collapse.in').css({'display':'none'});
	$('#logo-birdy').css({'left':'0px'});
}

function init_smartph() {
	$('.sidebar-bonjour').css({'display':'block'});
	$('.sidebar').css({'width': ' 100%'});
	$('#page-wrapper').css({'margin' :'0'});
	$('.tit_disp').css({'display':'inline'});
	$('.sidebar .arrow').css({'display':'inline'});
	$('.navbar-brand img').css({'margin' : '-23px 0 0 -7px'});
	$('#side-menu .collapse.in').css({'display':'block'});
	$('#handle').css({'display':'none'});
	$('#toggle-fullscreen').css({'display':'none'});
}

function ouverture_menu() {
	$('.sidebar').css({'width': ' 250px'});
	$('#page-wrapper').css({'margin' :'0 0 0 250px'});
	$('.tit_disp').css({'display':'inline'});
	$('.sidebar .arrow').css({'display':'inline'});
	$('#reduire_menu').css({'display':'inline'});
	$('.sidebar-bonjour').css({'display':'block'});
	$('#side-menu>li>a').css({'padding': '10px 15px'});
	$('.navbar-brand img').css({'margin' : '-23px 0 0 10px'});
	$('#side-menu .collapse.in').css({'display':'block'});
	$('#logo-birdy').css({'left':'45px'});
}

$('#handle').on('click touchstart', function(event) {
	if($i%2 == 0) {
		ouverture_menu();
	} else {
		fermeture_menu();
    }
    $i++;
    event.preventDefault();

});

$('.sidebar ul li').on('click', function() {
	if($(window).width()>768) ouverture_menu();
});
        