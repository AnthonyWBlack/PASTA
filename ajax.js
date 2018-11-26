function postAjax(page,postData){
	// Ajax request using the POST method
	try{
		// Try different methods for compatibility with different browsers
		globals.xmlHttp = new XMLHttpRequest();
	}
	catch(e){
		try{
			globals.xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				globals.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
			catch(e){
				// If none of the methods work, inform the user
				window.alert("Your browser is unable to connect to the server!");
				return(false);
			}
		}
	}
	// Prepare to handle the response
	globals.xmlHttp.onreadystatechange = function(){
		if(globals.xmlHttp.readyState == 4){
			var dataOut = globals.xmlHttp.responseText;
			ajaxOut(dataOut, null);
		}
	}
	// Send the request using the POST method and pre-formatted Data
	globals.xmlHttp.open("POST", page, true);
	globals.xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=ISO-8859-1");
	globals.xmlHttp.send(postData);
}

window.onunload = function(){
	// Delete the request object when the user navigates away for security
	delete(globals.xmlHttp.request);
}


function ajaxOut(dataOut){
	// Save the data request for the content and menu
	globals.serverData = dataOut;
	var datas = globals.serverData.split("··");
	document.title = datas[0]
	document.getElementById("pNav").innerHTML = datas[1];
	document.getElementById("pCon").innerHTML = datas[2];
	if(datas.length > 3){
		globals.userID = datas[3];
		globals.serverCookie = datas[4];
	}
}