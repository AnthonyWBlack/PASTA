var globals = {
	// Global variables!
	buttons:[], // An array of cBtn (button) objects
	cnvs:null, // The canvas display context
	cnvsH:256, // Canvas height and width
	cnvsW:256,
	dat:null, // Timer interval - each time it fires, send a data request to the server
	delimit:String.fromCharCode(127),
	eCanvas:null, // The canvas element from which cnvs is derived
	images:[], // An array of images to be loaded
	imagesLoading:0, // The number of images still being loaded
	imgSrc:[], // The source file name for each image
	mDown:false, // Is the mouse being held down?
	mode:0, // The current application mode
	mouseX:0, // The mouse position on the canvas
	mouseY:0,
	mxEnd:0,
	nextMode:"M0", // The mode to change to next
	optionPane:false, // Display the option pane
	postData:"", // The data to send to the server
	serverData:"", // Data received from the server
	serverIO:[], // An array of server requests and responses for debugging purposes
	Size:4, // 3D size scaling
	snapped:false, // Has the interface been clicked on or touched in the last Frame?
	tmr:null, // The main timer, set to 25FPS if possible
	userID:"", // The user ID from the server
	updateDisplay:true, // Controls display updates
	xmlHttp:null, // The AJAX object
	xOff:128, // 2D coordinate offsets
	yOff:128,
	zOff:-14, // 3D depth offset
	zScale:2, // 3D depth scale
	zMult:0.006, // Controls distortion further from the observer
	debug:"" // Debug text
};

var startUp = function(inst){
	// Initialise the program
	var pPtr = 0, wPtr = 0, plt, typ;
	globals.imagesLoading = globals.imgSrc.length; // Start loading any PNG, GIF or JPG images from the server into memory
	for(wPtr = 0; wPtr < globals.imgSrc.length; wPtr++){ // Create a function for each image object to decrement the counter on loading
		globals.images[wPtr] = new Image();
		globals.images[wPtr].onload = function(){
			globals.imagesLoading--;
		}
		globals.images[wPtr].src = "img/" + globals.imgSrc[wPtr]; // Specify the source of each image
	}
	globals.eCanvas = document.getElementById("display"); // Define the canvas for drawing commands
	/*globals.eCanvas.addEventListener("mousemove", mouseXY); // Add event listeners for user input
	globals.eCanvas.addEventListener("touchmove", mouseXY); // Swiping to rotate the 3D board
	globals.eCanvas.addEventListener("click", clicked); // Clicking
	globals.eCanvas.addEventListener("mousedown", mooseDown); // Pressing the mouse button or touch screen
	globals.eCanvas.addEventListener("touchstart", mooseDown);
	globals.eCanvas.addEventListener("mouseup", mooseUp); // Releasing the mouse button or touch screen
	globals.eCanvas.addEventListener("touchend", mooseUp);
	globals.eCanvas.addEventListener("mouseout", mooseUp);
	globals.eCanvas.addEventListener("touchcancel", mooseUp);
	window.addEventListener("resize", displaySize); // Resizing the window or display
	displaySize(); // Resize the canvas to fill the display at its current size*/
	globals.cnvs = globals.eCanvas.getContext("2d"); // Bind the canvas element to an object in RAM
	globals.cnvs.translate(globals.xOff, globals.yOff); // Centre the drawing commands
	//globals.tmr = setInterval(mains,40); // Aim for 25 fps
	loadM(inst);
}

var loadM = function(mde){
	globals.nextMode = "M" + mde;
	globals.postData = "pastaCMD=" + globals.nextMode;
	if(mde == 400){
		// End User Auto-Logon
		globals.postData += globals.delimit + urlData.d0 + globals.delimit + urlData.d1;
	}
	postAjax(PASTA_IDX + "/data.php", globals.postData);
}

var loginForm = function(){
	if(document.getElementById("loginUN").value.length > 4 && document.getElementById("loginPW").value.length > 7){
		globals.nextMode = "M100";
		globals.postData = "pastaCMD=" + globals.nextMode + globals.delimit + document.getElementById("loginUN").value + globals.delimit + document.getElementById("loginPW").value;
		postAjax(PASTA_IDX + "/data.php", globals.postData);
	}else{
		window.alert("Please make sure your username is at least 5 characters long and your password is at least 8 characters long.");
	}
}

var signUpForm = function(){
	if(document.getElementById("supEML").value.length > 5 && document.getElementById("supEML").value.indexOf("@") > 0 && document.getElementById("supEML").value.lastIndexOf(".") > document.getElementById("supEML").value.indexOf("@") && document.getElementById("supFN").value.length > 1 && document.getElementById("supSN").value.length > 1){
		globals.nextMode = "M3";
		globals.postData = "pastaCMD=" + globals.nextMode + globals.delimit + document.getElementById("supEML").value + globals.delimit + document.getElementById("supFN").value + globals.delimit + document.getElementById("supSN").value;
		postAjax(PASTA_IDX + "/data.php", globals.postData);
	}else{
		window.alert("Please make sure you have typed a valid email address and that you have typed in your first name and surname.");
	}
}

var issuePwd = function(UID){
	globals.nextMode = "M121";
	globals.postData = "pastaCMD=" + globals.nextMode + globals.delimit + UID + globals.delimit + "EmailPass";
	postAjax("http://barcodebattler.co.uk/pasta/data.php", globals.postData);
}

var logFault = function(){
	if(document.getElementById("LogFaultSev").selectedIndex > 0 && document.getElementById("LogFaultTyp").selectedIndex && document.getElementById("LogFaultCom").value.length > 16){
		globals.nextMode = "M404";
		globals.postData = "pastaCMD=" + globals.nextMode + globals.delimit + document.getElementById("LogFaultSev").value + globals.delimit + document.getElementById("LogFaultTyp").value + globals.delimit + document.getElementById("LogFaultCom").value;
		postAjax("http://barcodebattler.co.uk/pasta/data.php", globals.postData);
	}else{
		window.alert("Please select a severity, a type and type a descriptive comment.");
	}
}

var newFeature = function(UID){
	window.alert("Function to be added.");
}

var verifyUser = function(UID){
	globals.nextMode = "M123";
	globals.postData = "pastaCMD=" + globals.nextMode + globals.delimit + UID + globals.delimit + "EmailConf";
	postAjax("http://barcodebattler.co.uk/pasta/data.php", globals.postData);
}