
 	$(document).ready(function() {
		//setup front side canvas
 		canvas = new fabric.Canvas('tcanvas', {
		  hoverCursor: 'pointer',
		  selection: true,
		  selectionBorderColor:'blue'
		});


	  	$(".img-polaroid").click(function(e){
	  		var design = $(this).attr("src");

      	$('#shirtDiv').css({
				'backgroundImage': 'url(' + design +')',
				'backgroundRepeat': 'no-repeat',
				'backgroundPosition': 'top center',
				'background-size': '100% 100%'

        			});

        document.getElementById("shirtDiv").style.backgroundImage = design;
        document.getElementById("hfcol").value = design;

    	});




      // //Assign background color
      //  $('.img-polaroid').click(function(){
      // 		   var design = $(this).css("background-image");
      //        // var color_name = $(this).attr("title");
      //
      // 		   document.getElementById("shirtDiv").style.backgroundImage = design;
      //        // document.getElementById("shirtDiv").style.backgroundColor = color_name;
      //
      //        // var color_hex = rgb2hex(color);
      //        // document.getElementById("hfcol").value = color_hex;
      //        document.getElementById("pattern").value = design;
      // 	   });


    	   $(".clearfix button,a").tooltip();
	 });//doc ready


	 function onObjectSelected(e) {

	  }
	 function onSelectedCleared(e){
	 }
