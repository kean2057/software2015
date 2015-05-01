/*!
  Retrieve xml records and build a table
*/



function getDonor(e)
{
    var donorName = e.toString();
	
	if(donorName.length < 2)
		return;
	//alert(donorName);
	donorName = donorName.toUpperCase();

    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", "SampleData/SampleDonors.xml", false);
    xmlhttp.send();
    xmlDoc = xmlhttp.responseXML;


    var newTable = "";

	var x = xmlDoc.getElementsByTagName("song");

	newTable += "<div class=\"iput-group\">";
    var j = 0;
	for (i = 0; i < x.length; i++) {
        if (x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue.toUpperCase().startsWith(donorName)) {

			
			newTable += "<label class=\"list-group-item\"><input name=\"donor\" type=\"radio\">";
			newTable += x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue;
			newTable += "</label>";
        }
    }
	newTable += "</div>";
    
    document.getElementById("output").innerHTML = newTable;
}

