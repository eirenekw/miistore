//* CTRL + P key is disabled *//
$(document).bind("keyup keydown", function(e){
	if (e.ctrlKey && e.keyCode === 80) {
		return false;
	}
	return true;
});

$(document).ready(function() {
	//* sidebar-menu-child *//
	$(".sidebar-child").click(function(e){
		e.preventDefault;
		$this=$(this);
		$this.find(".sidebar-second-child").slideToggle(500);
		$this.siblings(".sidebar-child").not(this).find(".sidebar-second-child").slideUp(500);
		$this.find(".sidebar-fa").toggleClass('fa-angle-down fa-angle-up');
		$this.siblings(".sidebar-child").not(this).find(".fa-angle-up").toggleClass('fa-angle-up fa-angle-down');
	});
	
	//* menu-toggle *//
    $("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
	
	//* datatables *//
	$("#data").DataTable({
		"pageLength": 15,
		"pagingType": "first_last_numbers",
		"ordering": false,
		"info": false
	});
	
	//* delete confirmation *//
	$("a.btn-show").click(function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var modal_id = "confirm-delete_"+id;
		$("#"+modal_id).modal("show");
	});
	
	$(".btn btn-danger").click(function(e){
		var id = $(this).attr("id");
		var modal_id = "confirm-delete_"+id;
		$("#"+modal_id).modal("hide");
	});
	
	//* image upload single *//
	function readURL(input){
		if(input.files && input.files[0]){
			var image_preview = $("#image-preview-div");
			image_preview.empty();
			
			var reader = new FileReader();
			reader.onload = function(e){
				$("<img />", {
					"src": e.target.result,
					"class": "preview-img"
				}).appendTo(image_preview);
			}
			image_preview.show();
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#imgjs").change(function(){
		$("#message").empty();
			
		var file = this.files[0];
		var match = ['image/jpeg', 'image/png', 'image/jpg'];
			
		if(!((file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]))){
			$("#message").html("<span class='text-danger'>Unvalid image format. Allowed formats: JPG, JPEG and PNG</span>");
			return false;
		}
			
		if(file.size > (1024*1024)){
			$("#message").html("<span class='text-danger'>Unvalid image size. Maximum size is 1 MB</span>");
			return false;
		}
		
		readURL(this);
	});
	
	//* image upload multiple *//
	$("#preview").on('click','.thumb-image-multiple',function(){
		$(this).toggleClass(".selectedItem");
	});

	$("#btnDelete").on("click",function(){
		$(".selectedItem").remove();
	});

	$("#image").on('change', function() {
		//Get count of selected files
		var countFiles = $(this)[0].files.length;
		var imgPath = $(this)[0].value;
		var fileSize = $(this)[0].files;
				
		var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		var preview_image = $("#preview");
		$("#message").empty();
		preview_image.empty();
		
		if(countFiles > 0){
			if (extn == "jpg" || extn == "jpeg") {
				if (typeof(FileReader) != "undefined") {
				//loop for each file selected for uploaded.
					for (var i = 0; i < countFiles; i++) {
						if(fileSize[i].size > 1048576){
							$("#message").html("<span class='text-danger'>Image size must not be more than 1 MB</span>");
							$(this).val('');
						}
						
						var reader = new FileReader();
						
						reader.onload = function(e) {
							$("<img>", {
								"src": e.target.result,
								"class": "thumb-image-multiple"
							}).appendTo(preview_image);
						}
						preview_image.show();
						reader.readAsDataURL($(this)[0].files[i]);
					}
							
				}else{
					$("#message").html("<span class='text-danger'>This browser does not support FileReader</span>");
				}
			}else{
				$("#message").html("<span class='text-danger'>Unvalid image format. Allowed formats: JPG and JPEG</span>");
			}
		}
	});
	
	$("#catid").change(function(){
		var catid = $("#catid").val();
		$.ajax({
			url: "cat_subcat.php",
			data: "catid="+catid,
			success: function(data){
				$("#subcat").html(data);
			}
		});
	});
	
	$("#startdate").datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
	}).on('changeDate', function(selected){
		var minDate = new Date(selected.date.valueOf());
		$("#enddate").datepicker('setStartDate', minDate);
	});
	
	$("#enddate").datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true
	}).on('changeDate', function(selected){
		var maxDate = new Date(selected.date.valueOf());
		$("#startdate").datepicker('setEndDate', maxDate);
	});
	
	$("#reset-date").click(function(e){
		e.preventDefault();
		$(".date1").val("");
		$(".date2").val("");
		$(".orderbydate").hide();
	});	
	
	$("#resetcatsubcat").on("click",function(){
		$('#catid option').prop('selected', function(){
			return this.defaultSelected;
		});
		
		$('#subcat option').prop('selected', function(){
			return this.defaultSelected;
		});
	});
});

/** Print without CTRL + P key **/
function PrintDiv(divName){
	var printContents = document.getElementById(divName).innerHTML;
	var orginialContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = orginialContents;
	window.location.reload(true);
}

function customselected(){
	var findd = document.getElementById("subcat").value;
		
	$.ajax({
		url:"catsubcat.php", 
		data: "s="+findd, 
		success: function(data){ 
			$(".catsubcat").html(data).show();
		}
	});
}