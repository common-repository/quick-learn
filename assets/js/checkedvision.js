function eyeicon() {
 var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }  
}
function eye_icon() {
 var x1 = document.getElementById("confirm_password");
  if (x1.type === "password") {
    x1.type = "text";
  } else {
    x1.type = "password";
  }
}

var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}
  function validateForm() {
      var x = document.forms["myForm"]["uname"].value.trim();

          if (x == "") {
            document.getElementById("div1").innerHTML="Please Enter User Name";
            document.getElementById("div1").style.color="Red";
            return false;
      }
     /* var x = document.forms["myForm"]["email"].value.trim();
          if (x == "") {
            document.getElementById("div2").innerHTML="Email must be filled out";
            document.getElementById("div2").style.color="Red";
            return false;
      }*/
      var user_id=document.getElementById("email");
      var filter=/^([a-z A-Z 0-9 _\.\-])+\@(([a-z A-Z 0-9\-])+\.)+([a-z A-z 0-9]{3,3})+$/;
      if(!filter.test(user_id.value))
      {
     document.getElementById("div2").innerHTML="Email is in www.gmail.com format";
      document.getElementById("div2").style.color="Red";
      user_id.focus();
      return false;
      }
      var x = document.forms["myForm"]["password"].value.trim();
          if (x == "") {
            document.getElementById("div3").innerHTML="Password must be filled out";
            document.getElementById("div3").style.color="Red";
            return false;
      }
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            alert('password matches successfully');
     }

  
  
