/*Color Picker*/
//convert to hex color code
function rgb2hex(rgb){
 rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
 return (rgb && rgb.length === 4) ? "#" +
  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
}

$('button').click(function(){
    var hex = rgb2hex( $('input').val() );
    $('.result').html( hex );
});

  $(document).ready(function() {
		//setup front side canvas
 		canvas = new fabric.Canvas('tcanvas', {
		  hoverCursor: 'pointer',
		  selection: true,
		  selectionBorderColor:'blue'
		});
 		canvas.on({
			 'object:moving': function(e) {
			    e.target.opacity = 0.5;
			  },
			  'object:modified': function(e) {
			    e.target.opacity = 1;
			  },
			 'object:selected':onObjectSelected,
			 'selection:cleared':onSelectedCleared
		 });

//Assign background color
 $('.color-preview').click(function(){
		   var color = $(this).css("background-color");
       var color_name = $(this).attr("title");

		   document.getElementById("shirtDiv").style.backgroundColor = color;
       document.getElementById("shirtDiv").style.backgroundColor = color_name;

       var color_hex = rgb2hex(color);
       document.getElementById("hfcol").value = color_hex;
       document.getElementById("hfcol2").value = color_name;
	   });

	   $(".clearfix button,a").tooltip();
	   line1 = new fabric.Line([0,0,200,0], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
	   line2 = new fabric.Line([199,0,200,399], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
	   line3 = new fabric.Line([0,0,0,400], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
	   line4 = new fabric.Line([0,400,200,399], {"stroke":"#000000", "strokeWidth":1,hasBorders:false,hasControls:false,hasRotatingPoint:false,selectable:false});
	 });

	 function onObjectSelected(e) {
	    var selectedObject = e.target;
	    $("#text-string").val("");
	    selectedObject.hasRotatingPoint = true
	    if (selectedObject && selectedObject.type === 'text') {
	    	//display text editor

	    	$("#imageeditor").css('display', 'block');
	    }
	    else if (selectedObject && selectedObject.type === 'image'){
	    	//display image editor
	    	$("#imageeditor").css('display', 'block');
	    }
	  }
	 function onSelectedCleared(e){
		 $("#imageeditor").css('display', 'none');
	 }

	 function removeWhite(){
		  var activeObject = canvas.getActiveObject();
		  if (activeObject && activeObject.type === 'image') {
			  activeObject.filters[2] =  new fabric.Image.filters.RemoveWhite({hreshold: 100, distance: 10});//0-255, 0-255
			  activeObject.applyFilters(canvas.renderAll.bind(canvas));
		  }
	 }
