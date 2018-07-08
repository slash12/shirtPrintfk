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

  $(".clearfix button,a").tooltip();
});//doc ready


function onObjectSelected(e) {

}
function onSelectedCleared(e){
}
