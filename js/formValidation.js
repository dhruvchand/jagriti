function validateForm()
{
	var x=document.forms["submit_form"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		alert("Not a valid e-mail address.\nPlease try again.");
		return false;
	}

	var x=document.forms["submit_form"]["address"].value;
	if (x=="" || x==null)
	{
		alert("Not a valid Address.\nPlease try again");
		return false;
	}
	var x=document.forms["submit_form"]["description"].value;
	if (x=="" || x==null)
	{
		alert("Not a valid description.\nPlease try again");
		return false;
	}

	//Add some more stuff :P
}