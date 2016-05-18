function MenuItem_OnMouseOver(num)
{
	document.body.style.cursor = "pointer";
	document.getElementById("AdminBtn"+num).style.backgroundColor = "#CCFFFF";
}

function MenuItem_OnMouseOut(num)
{
	document.body.style.cursor = "default";
	document.getElementById("AdminBtn"+num).style.backgroundColor = "#CCCCCC";
}

//function to disable submit button unless user fills in form
function didFillAllNewTherapistInputs()
{
	if(document.getElementById('ADDFirstName').value == "" || document.getElementById('ADDLastName').value == "" || document.getElementById('ADDUserName').value == "" || 
	   document.getElementById('ADDPassword').value == "" || document.getElementById('ADDPassword2').value == "" || document.getElementById('ADDEmail').value == ""
	  )
		document.getElementById('newTherapistBtn').disabled = true;
	
	else
		document.getElementById('newTherapistBtn').disabled = false;              
}

//function to disable submit button unless user fills in form
function didFillAllDeleteTherapistInputs()
{
	if(document.getElementById('DELUserName').value == "" || document.getElementById('NewTherapistID').value == "")
		document.getElementById('deleteTherapistBtn').disabled = true;
	
	else
		document.getElementById('deleteTherapistBtn').disabled = false;              
}

//function to disable submit button unless user fills in form
function didFillAllChangePWTherapistInputs()
{
	if(document.getElementById('PasswordChangeUserName').value == "" || document.getElementById('NewPW').value == "" || document.getElementById('NewPWConfirm').value == "")
		document.getElementById('changeTherapistPWBtn').disabled = true;
	
	else
		document.getElementById('changeTherapistPWBtn').disabled = false;              
}

//ADD THERAPIST
function toggleAddTherapistInterface()
{
	var doc = document.getElementById('newTherapistDiv');
	var doc2 = document.getElementById('deleteTherapistDiv');
	var doc3 = document.getElementById('changeTherapistPWDiv');

	doc2.style.visibility = 'hidden';
	doc3.style.visibility = 'hidden';

	if (doc.style.visibility == 'hidden')
	{
		doc.style.visibility = 'visible';
	}
	else
	{
		doc.style.visibility = 'hidden';
	}
	document.getElementById('ADDTherapistID').value = "";
	document.getElementById('ADDFirstName').value = "";
	document.getElementById('ADDLastName').value = "";
	document.getElementById('ADDUserName').value = "";
	document.getElementById('ADDPassword').value = "";
	document.getElementById('ADDPassword2').value = "";
	this.didFillAllNewTherapistInputs();
}

//Toggle Delete Therapist Form
function toggleDeleteTherapistInterface()
{
    var doc = document.getElementById('deleteTherapistDiv');
    var doc2 = document.getElementById('newTherapistDiv');
    var doc3 = document.getElementById('changeTherapistPWDiv');
    
    doc2.style.visibility = 'hidden';
    doc3.style.visibility = 'hidden';
    
    if (doc.style.visibility == 'hidden')
    {
        doc.style.visibility = 'visible';
    }
    else
    {
        doc.style.visibility = 'hidden';
    }
    document.getElementById('DelUserName').value = "";
    this.didFillAllDeleteTherapistInputs();
}

//Toggle Change Password Form

function toggleChangePWInterface()
{
    var doc = document.getElementById('changeTherapistPWDiv');
    var doc2 = document.getElementById('deleteTherapistDiv');
    var doc3 = document.getElementById('newTherapistDiv');
    
    doc2.style.visibility = 'hidden';
    doc3.style.visibility = 'hidden';

    if (doc.style.visibility == 'hidden')
    {
        doc.style.visibility = 'visible';
    }
    else
    {
        doc.style.visibility = 'hidden';
    }
    document.getElementById('PasswordChangeUserName').value = "";
    document.getElementById('NewPW').value = "";
    document.getElementById('NewPWConfirm').value = "";
    this.didFillAllChangePWTherapistInputs();
}

function newTherapist(id)
{
	if (confirm("Are you sure you wish to add this therapist?") == true)
	{
		this.submitForm(id);
	}
}

function deleteTheTherapist(id)
{
	if (confirm("Are you sure you wish to delete this therapist?") == true)
	{
		this.submitForm(id);
	}
}

function changePW(id)
{
	if (confirm("Are you sure you wish to change the password?") == true)
	{
		this.submitForm(id);
	}
}

function submitForm(id)
{
	var form = document.getElementById(id);
	form.setAttribute("method", "post");
	form.setAttribute("action", "AdminSettings.php");
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "submittedForm");
	hiddenField.setAttribute("value", id);
	form.appendChild(hiddenField);
	form.submit();
}


/*
function AddNewTherapistAJAX()
{
	var ID = document.getElementById('ADDTherapistID').value;
	var fName = document.getElementById('ADDFirstName').value;
	var lName = document.getElementById('ADDLastName').value;
	var user = document.getElementById('ADDUserName').value;
	var password = document.getElementById('ADDPassword').value;
	var password2 = document.getElementById('ADDPassword2').value;
	var email = document.getElementById('ADDEmail').value;



	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert(user+" added successfully!");
			toggleAddPattientInterface();
		}
	}

	if (password == password2)
	{
		xmlhttp.open("GET","AddUserAJAX.php?uname="+user+"&pwd="+password+"&fName="+fName+"&lName="+lName+"&email="+email, true);
		xmlhttp.send();
	}
	else
	{
		alert("Passwords must match");
	}
}
	//DELETE


function deleteUser()
{
	if (confirm("Are you sure you with to delete this user?") == true)
	{
	deleteUserAJAX();
	}
}



function deleteUserAJAX()
{
var user = document.getElementById('DELUserName').value;

xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
alert(user+" deleted successfully!");
toggleDeleteUserInterface();
}
}

xmlhttp.open("GET","DeleteUserAJAX.php?uname="+user, true);
xmlhttp.send();
}


//CHANGE PASSWORD

function changePW()
{
if (confirm("Are you sure you wish to change this user's password?") == true)
{
changePWAJAX();
}

}



function changePWAJAX()
{
var user = document.getElementById('PasswordChangeUserName').value;
var password1= document.getElementById('NewPW').value;
var password2= document.getElementById('NewPWConfirm').value;

xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
alert(user+" password changed successfully!");
toggleChangePWInterface();
}
}
if (password1 == password2)
{
xmlhttp.open("GET","ChangePWAJAX.php?uname="+user+"&pw="+password1, true);
xmlhttp.send();
}
else
{
alert("Passwords must match");
}



}
*/