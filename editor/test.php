
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Adding an &lt;img&gt; element to &lt;canvas&gt; using Fabric.js</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <script
    type="text/javascript"
    src="/js/lib/dummy.js"

  ></script>

    <link rel="stylesheet" type="text/css" href="/css/result-light.css">

      <script type="text/javascript" src="http://rawgithub.com/kangax/fabric.js/master/dist/all.js"></script>
      <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.5.0/fabric.js"></script>
  <style type="text/css">
    #canvas-container {
    position: relative;
    width: 800px;
    height: 600px;
    box-shadow: 0 0 5px 1px black;
    margin: 10px auto;
    border: 5px solid transparent;
}
#canvas-container.over {
    border: 5px dashed cyan;
}
#images img.img_dragging {
    opacity: 0.4;
}
/*
Styles below based on  http://www.html5rocks.com/en/tutorials/dnd/basics/
*/

/* Prevent the text contents of draggable elements from being selectable. */
[draggable] {
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    /* Required to make elements draggable in old WebKit */
    -khtml-user-drag: element;
    -webkit-user-drag: element;
    cursor: move;
}
  </style>
  <!-- TODO: Missing CoffeeScript 2 -->

  <script type="text/javascript">


    window.onload=function(){

/* Drag and Drop code adapted from http://www.html5rocks.com/en/tutorials/dnd/basics/ */

var canvas = new fabric.Canvas('canvas');

/*
NOTE: the start and end handlers are events for the <img> elements; the rest are bound to
the canvas container.
*/

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

    e.dataTransfer.dropEffect = 'copy'; // See the section on the DataTransfer object.
    // NOTE: comment above refers to the article (see top) -natchiketa

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

    }

</script>

</head>
<body>
  <!-- Based on the tutorial at http://www.html5rocks.com/en/tutorials/dnd/basics/ -->
<div id="images">
    <img draggable="true" src="http://i.imgur.com/8rmMZI3.jpg" width="100" height="100"></img>
    <img draggable="true" src="http://i.imgur.com/q9aLMza.png" width="100" height="100"></img>
    <img draggable="true" src="http://i.imgur.com/wMU4SFn.jpg" width="100" height="100"></img>
</div>

<!-- NOTE: Fabric.js sets both the <canvas> element and the wrapper element which it
creates to be user-unselectable using CSS properties (e.g. for Webkit, this is
-webkit-user-select: none;). We could remove that property during the dragging, but
I'm just going to wrap the canvas in a container and bind events to that, which is
less intrusive.
 -->
<div id="canvas-container">
    <canvas id="canvas" width="800" height="600"></canvas>
</div>


  <script>
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent){
      window.parent.parent.postMessage(["resultsFrame", {
        height: document.body.getBoundingClientRect().height,
        slug: "w8kkc"
      }], "*")
    }
  </script>
</body>
</html>
