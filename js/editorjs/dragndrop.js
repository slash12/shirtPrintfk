window.onload=function(){
  var imageLoader = document.getElementById('imageLoader');
  var canvas = new fabric.Canvas('canvas' ,{ isDrawingMode: false } ,{selection: true,uniScaleTransform: true});
  //remove from canvas
  $("#select").click(function(){
    canvas.isDrawingMode = false;
  });
  // $("#draw").click(function(){
  //     canvas.isDrawingMode = true;
  // });
  $("#delete").click(function(){
    canvas.isDrawingMode = false;
    deleteObjects();
    canvas.remove(canvas.getActiveObject());
  });
  // drag n drop
  function handleDragStart(e) {
    [].forEach.call(images, function (img) {
      img.classList.remove('img_dragging');
    });
    this.classList.add('img_dragging');
  }

  function handleDragOver(e) {
    if (e.preventDefault) {
      e.preventDefault(); // Necessary. Allows us to drop.
    }
    e.dataTransfer.dropEffect = 'copy';
    return false;
  }

  function handleDragEnter(e) {
    // this / e.target is the current hover target.
    this.classList.add('over');
  }

  function handleDragLeave(e) {
    this.classList.remove('over'); // this / e.target is previous target element.
  }

  function handleDrop(e) {
    // this / e.target is current target element.

    if (e.stopPropagation) {
      e.stopPropagation(); // stops the browser from redirecting.
    }

    var img = document.querySelector('#images img.img_dragging');

    console.log('event: ', e);

    var newImage = new fabric.Image(img, {
      width: img.width,
      height: img.height,
      // Set the center of the new object based on the event coordinates relative
      // to the canvas container.
      left: e.layerX,
      top: e.layerY
    });
    canvas.add(newImage);

    return false;
  }


  // select all objects and delete
  function deleteObjects(){
    var activeObject = canvas.getActiveObject(),
    activeGroup = canvas.getActiveGroup();
    if (activeObject) {

      canvas.remove(activeObject);

    }
    else if (activeGroup) {

      var objectsInGroup = activeGroup.getObjects();
      canvas.discardActiveGroup();
      objectsInGroup.forEach(function(object) {
        canvas.remove(object);
      });

    }
  }
  function handleDragEnd(e) {
    // this/e.target is the source node.
    [].forEach.call(images, function (img) {
      img.classList.remove('img_dragging');
    });
  }

  if (Modernizr.draganddrop) {
    // Browser supports HTML5 DnD.

    // Bind the event listeners for the image elements
    var images = document.querySelectorAll('#images img');
    [].forEach.call(images, function (img) {
      img.addEventListener('dragstart', handleDragStart, false);
      img.addEventListener('dragend', handleDragEnd, false);
    });
    // Bind the event listeners for the canvas
    var canvasContainer = document.getElementById('canvas-container');
    canvasContainer.addEventListener('dragenter', handleDragEnter, false);
    canvasContainer.addEventListener('dragover', handleDragOver, false);
    canvasContainer.addEventListener('dragleave', handleDragLeave, false);
    canvasContainer.addEventListener('drop', handleDrop, false);
  } else {
    // Replace with a fallback to a library solution.
    alert("This browser doesn't support the HTML5 Drag and Drop API.");
  }
  // add text to canvas
  canvas.uniScaleTransform = true;
  var appObject = function() {

    return {
      __canvas: canvas,
      __tmpgroup: {},

      //as default
      addText: function() {
        var newID = (new Date()).getTime().toString().substr(5);
        var text = new fabric.IText('New Text', {
          fontFamily: 'arial',
          fontSize:15,
          left: 0,
          top: 0,
          myid: newID,
          objecttype: 'text'
        });

        this.__canvas.add(text);
        this.addLayer(newID, 'text');

      },
      setTextParam: function(param, value) {
        var obj = this.__canvas.getActiveObject();
        if (obj) {
          if (param == 'color') {
            obj.setColor(value);
          } else {
            obj.set(param, value);
          }
          this.__canvas.renderAll();
        }
      },
      setTextValue: function(value) {
        var obj = this.__canvas.getActiveObject();
        if (obj) {
          obj.setText(value);
          this.__canvas.renderAll();
        }
      },
      addLayer: function() {

      }

    };
  }

  $(document).ready(function() {

    var app = appObject();

    $('.font-change').change(function(event) {
      app.setTextParam($(this).data('type'), $(this).find('option:selected').val());
    });

    $('#add').click(function() {
      app.addText();
    });
    $('#text-cont').keyup(function() {
      app.setTextValue($(this).val());
    })

  })
  //send object front/back
  var selectedObject;
  canvas.on('object:selected', function(event) {
    selectedObject = event.target;
  });
  var sendSelectedObjectBack = function() {
    canvas.sendToBack(selectedObject);
  }
  var sendSelectedObjectToFront = function() {
    canvas.bringToFront(selectedObject);
  }
  //upload image to canvas
  document.getElementById('file').addEventListener("change", function (e) {
    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onload = function (f) {
      var data = f.target.result;
      fabric.Image.fromURL(data, function (img) {
        var oImg = img.set({left: 0, top: 0, angle: 00,width:100, height:100}).scale(0.9);
        canvas.add(oImg).renderAll();
        var a = canvas.setActiveObject(oImg);
        var dataURL = canvas.toDataURL({format: 'png', quality: 0.8});
      });
    };
    reader.readAsDataURL(file);
  });
  //bring to front
  canvas.on("object:selected", function(options) {
    options.target.bringToFront();
  });
  //BOLD ITALICS Underline
  // Text formatting actions
  var underline = document.getElementById('btn-underline');
  var bold = document.getElementById('btn-bold');
  var italic = document.getElementById('btn-italic');
  underline.addEventListener('click', function() {
    dtEditText('underline');
  });

  bold.addEventListener('click', function() {
    dtEditText('bold');
  });

  italic.addEventListener('click', function() {
    dtEditText('italic');
  });

  // Functions
  function dtEditText(action) {
    var a = action;
    var o = canvas.getActiveObject();
    var t;

    // If object selected, what type?
    if (o) {
      t = o.get('type');
    }

    if (o && t === 'i-text') {
      switch(a) {
        case 'bold':
        var isBold = dtGetStyle(o, 'fontWeight') === 'bold';
        dtSetStyle(o, 'fontWeight', isBold ? '' : 'bold');
        break;

        case 'italic':
        var isItalic = dtGetStyle(o, 'fontStyle') === 'italic';
        dtSetStyle(o, 'fontStyle', isItalic ? '' : 'italic');
        break;

        case 'underline':
        var isUnderline = dtGetStyle(o, 'textDecoration') === 'underline';
        dtSetStyle(o, 'textDecoration', isUnderline ? '' : 'underline');
        break;
        canvas.renderAll();
      }
    }
  }
  // Get the style
  function dtGetStyle(object, styleName) {
    return object[styleName];
  }
  // Set the style
  function dtSetStyle(object, styleName, value) {
    object.set(styleName, value);
    canvas.renderAll();
  }



  // canvas.getObjects().length




}
