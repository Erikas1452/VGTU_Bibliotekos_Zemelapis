

let canvas;
let ctx;
let widthCanvas;
let heightCanvas;

// View parameters
let xleftView = 0;
let ytopView = 0;
let widthViewOriginal = 1.0;           //actual width and height of zoomed and panned display
let heightViewOriginal = 1.0;
let widthView = widthViewOriginal;           //actual width and height of zoomed and panned display
let heightView = heightViewOriginal;

window.addEventListener("load",setup,false);

function setup() {
    canvas = document.getElementById("canvas");
    ctx = canvas.getContext("2d");

    widthCanvas = canvas.width;
    heightCanvas = canvas.height;

    canvas.addEventListener("mousedown", handleMouseDown, false); // click and hold to pan
    canvas.addEventListener("mouseup", handleMouseUp, false);
    canvas.addEventListener("mousemove", handleMouseMove, false);
    canvas.addEventListener("mousewheel", handleMouseWheel, false); // mousewheel duplicates dblclick function
    canvas.addEventListener("DOMMouseScroll", handleMouseWheel, false); // for Firefox

    draw();
}

function draw() {
    ctx.setTransform(1,0,0,1,0,0);
    ctx.scale(widthCanvas/widthView, heightCanvas/heightView);
    ctx.translate(-xleftView,-ytopView);

    ctx.fillStyle = "yellow";
    ctx.fillRect(xleftView,ytopView, widthView,heightView);
    ctx.fillStyle = "blue";
    ctx.fillRect(0.1,0.5,0.1,0.1);
    ctx.fillStyle = "red";
    ctx.fillRect(0.3,0.2,0.4,0.2);
    ctx.fillStyle="green";
    ctx.beginPath();
    ctx.arc(widthView/2+xleftView,heightView/2+ytopView,0.05,0,360,false);
    ctx.fill();
}

function handleDblClick(event) {
    let X = event.clientX - this.offsetLeft - this.clientLeft + this.scrollLeft; //Canvas coordinates
    let Y = event.clientY - this.offsetTop - this.clientTop + this.scrollTop;
    let x = X/widthCanvas * widthView + xleftView;  // View coordinates
    let y = Y/heightCanvas * heightView + ytopView;

    let scale = event.shiftKey == 1 ? 1.5 : 0.5; // shrink (1.5) if shift key pressed
    widthView *= scale;
    heightView *= scale;

    if (widthView > widthViewOriginal || heightView > heightViewOriginal) {
        widthView = widthViewOriginal;
        heightView = heightViewOriginal;
        x = widthView/2;
        y = heightView/2;
    }

    xleftView = x - widthView/2;
    ytopView = y - heightView/2;

    draw();
}

let mouseDown = false;

function handleMouseDown(event) {
    mouseDown = true;
}

function handleMouseUp(event) {
    mouseDown = false;
}

let lastX = 0;
let lastY = 0;
function handleMouseMove(event) {

    let X = event.clientX - this.offsetLeft - this.clientLeft + this.scrollLeft;
    let Y = event.clientY - this.offsetTop - this.clientTop + this.scrollTop;

    if (mouseDown) {
        let dx = (X - lastX) / widthCanvas * widthView;
        let dy = (Y - lastY)/ heightCanvas * heightView;
        xleftView -= dx;
        ytopView -= dy;
    }
    lastX = X;
    lastY = Y;

    draw();
}

function handleMouseWheel(event) {
    let x = widthView/2 + xleftView;  // View coordinates
    let y = heightView/2 + ytopView;

    let scale = (event.wheelDelta < 0 || event.detail > 0) ? 1.1 : 0.9;
    widthView *= scale;
    heightView *= scale;

    if (widthView > widthViewOriginal || heightView > heightViewOriginal) {
        widthView = widthViewOriginal;
        heightView = heightViewOriginal;
        x = widthView/2;
        y = heightView/2;
    }

    // scale about center of view, rather than mouse position. This is different than dblclick behavior.
    xleftView = x - widthView/2;
    ytopView = y - heightView/2;

    draw();
}