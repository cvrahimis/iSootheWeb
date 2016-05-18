var number = Number.NaN;
document.write(number);

function MenuItem_OnMouseOver(num)
{
	document.getElementById("TBtn"+num).style.backgroundColor = "#CCFFFF";
}



function MenuItem_OnMouseOut(num)
{
	document.getElementById("TBtn"+num).style.backgroundColor = "#CCCCCC";
}



//function to disable submit button unless user fills in form
function didFillAllNewPatientInputs()
{
    if(document.getElementById('ADDFirstName').value == "" || document.getElementById('ADDLastName').value == "" || document.getElementById('ADDUserName').value == "" ||
       document.getElementById('ADDPassword').value == "" || document.getElementById('ADDPassword2').value == "" || document.getElementById('ADDEmail').value == ""
       )
        document.getElementById('newPatientBtn').disabled = true;
    
    else
        document.getElementById('newPatientBtn').disabled = false;
}

//function to disable submit button unless user fills in form
function didFillAllDeletePatientInputs()
{
    if(document.getElementById('DELUserName').value == "")
        document.getElementById('deletePatientBtn').disabled = true;
    
    else
        document.getElementById('deletePatientBtn').disabled = false;
}

//function to disable submit button unless user fills in form
function didFillAllChangePWPatientInputs()
{
    if(document.getElementById('PasswordChangeUserName').value == "" || document.getElementById('OLDPW').value == ""  || document.getElementById('NEWPW').value == "" || document.getElementById('NewPWConfirm').value == "")
        document.getElementById('changePatientPWBtn').disabled = true;
    
    else
        document.getElementById('changePatientPWBtn').disabled = false;
}
//ADD PATIENT


function toggleAddPatientInterface()
{
	var doc = document.getElementById('NewPatientDiv');
	var doc2 = document.getElementById('DeleteDiv');
	var doc3 = document.getElementById('PatientPasswordDiv');

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
        document.getElementById('ADDPatientID').value = "";
		document.getElementById('ADDFirstName').value = "";
		document.getElementById('ADDLastName').value = "";
		document.getElementById('ADDUserName').value = "";
		document.getElementById('ADDPassword').value = "";
		document.getElementById('ADDPassword2').value = "";
        document.getElementById('AddEmail').value = "";
    	this.didFillAllNewPatientInputs();
}


//TOGGLE DELETE PATIENT

function toggleDeletePatientInterface()
{
    var doc = document.getElementById('DeleteDiv');
    var doc2 = document.getElementById('NewPatientDiv');
    var doc3 = document.getElementById('PatientPasswordDiv');

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
	this.didFillAllDeletePatientInputs();
}


//TOGGLE CHANGE PASSWORD

function toggleChangePWInterface()
{
    var doc = document.getElementById('PatientPasswordDiv');
    var doc2 = document.getElementById('DeleteDiv');
    var doc3 = document.getElementById('NewPatientDiv');
    
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
        document.getElementById('PasswordChangeUserNAme').value = "";
        document.getElementById('NewPW').value = "";
        document.getElementById('NewPWConfirm').value = "";
        this.didFillAllChangePWPatientInputs();
        
}
function newPatient(id)
{
    if (confirm("Are you sure you wish to add this patient?") == true)
    {
        this.submitForm(id);
    }
}

function deleteThePatient(id)
{
    if (confirm("Are you sure you wish to delete this patient?") == true)
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
    form.setAttribute("action", "TherapistSettings.php");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "submittedForm");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);
    form.submit();
}


/*

function AddNewPatientAJAX()
{
    var ID = document.getElementById('ADDPatientID').value;
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

