//* CTRL + P key is disabled *//
$(document).bind("keyup keydown", function(e){
	if (e.ctrlKey && e.keyCode === 80) {
		return false;
	}
	return true;
});

$(document).ready(function() {
	/** Slider **/	
	$('#example1').coreSlider({
		pauseOnHover: false,
		interval: 3000,
		controlNavEnabled: true
	});
	
	/** Scroll Top **/
	$(window).scroll(function(){
		if($(this).scrollTop() > 100){
			$(".scrollup").fadeIn();
		}else{
			$(".scrollup").fadeOut();
		}
	});
	
	$(".scrollup").click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
	
	//** Show/Hide Password **/
	$('.input-group-addon span').on('click', function(){
		var passwordField = $('#password');
		var passwordFieldType = passwordField.attr('type');
		if(passwordFieldType == 'password') {
			passwordField.attr('type', 'text');
			$(this).text('Hide');
		}else{
			passwordField.attr('type', 'password');
			$(this).text('Show');
		}
	});
	
	$('#totals').modal('show');
	$('#fields').modal('show');
	
	$("#card_bank").change(function(){
		var bank = this.value;
		
		if(bank == 'Bank BCA'){
			$("#card_number").focus();
			$("#card_number").attr('maxLength','10');
			$("#card_number").val('');
		}else if(bank == 'Bank Mandiri'){
			$("#card_number").focus();
			$("#card_number").attr('maxLength','13');
			$("#card_number").val('');
		}else if(bank == 'Bank BNI'){
			$("#card_number").focus();
			$("#card_number").attr('maxLength','9');
			$("#card_number").val('');
		}else if(bank == 'Bank BRI'){
			$("#card_number").focus();
			$("#card_number").attr('maxLength','15');
			$("#card_number").val('');
		}
	});
	
	$("#search").keyup(function(){
		var find = $(this).val();
		if(find != ""){
			$.ajax({
				url:"search.php", 
				data: "key="+find, 
				success: function(data){ 
					$(".top-products").html(data).show();
				} 
			});
		} else {
			window.location.href = "index.php";
		}
		return false;
	});
	
});

/** Carousel **/
$('#myCarousel').carousel({ interval: 2000 });
$('.carousel-show .item').each(function(){
	var next = $(this).next();
		
	if(!next.length) {
		next = $(this).siblings(':first');
	}
		
	next.children(':first-child').clone().appendTo($(this));
		
	for(var i = 0; i < 4; i++) {
		next = next.next();
			
		if(!next.length) {
			next = $(this).siblings(':first');
		}
		next.children(':first-child').clone().addClass('cloned-'+(i)).appendTo($(this));
	}
});

/** Thumbnails Slide **/
$(window).load(function(){
	$('.flexslider').flexslider({
		animation: "slide",
		controlNav: "thumbnails"
	});
});

/** Print without CTRL + P key **/
function PrintDiv(divName){
	var printContents = document.getElementById(divName).innerHTML;
	var orginialContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = orginialContents;
}
