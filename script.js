

/* --------------- Register Form Validation --------------------- */  


//User Name
let userNameInput = document.getElementById("user_name_input");
let userNameError = document.getElementById("user_name_error");
let userNameEmpty = document.getElementById("user_name_empty");

//Email
let emailInput = document.getElementById("email_input");
let emailError = document.getElementById("email_error");
let emailEmpty = document.getElementById("email_empty");


//Password
let passwordInput = document.getElementById("password_input");
let passwordError = document.getElementById("password_error");
let passwordEmpty = document.getElementById("password_empty");
let showbtn = document.getElementById("showbtn");

//confirmPassword
let confirmPasswordInput = document.getElementById("confirm_password_input");
let confirmPasswordError = document.getElementById("confirm_password_error");
let confirmPasswordEmpty = document.getElementById("confirm_password_empty");
let showbtn2 = document.getElementById("showbtn2");



//Submit
let registerBtn = document.getElementById("submit_btn");

//Valid
let validCls = document.getElementsByClassName("valid");
let invalidCls = document.getElementsByClassName("error");


//User Name Verification
const textVerify = (text) => {
const regex = /^[a-z0-9_-]{3,15}$/;
return regex.test(text);
};
  
//Email verification
const emailVerify = (input) => {
const regex = /^[a-z0-9_]+@[a-z]{3,}\.[a-z\.]{3,}$/;
return regex.test(input);
};


//Password Verification
const passwordVerify = (password) => {
const regex =
/^(?=.+[a-z])(?=.+[A-Z])(?=.+[0-9])(?=.+[\$\%\^\&\!@\#\*\(\)\+\=\?\>\<])/;
return regex.test(password) && password.length >= 8;
};


//Confirm Password Verification 
const confirmPasswordVerify = () => {
  return confirmPasswordInput.value === passwordInput.value;
};

//Password Validation
let vallowChar = document.getElementById('lowChar');
let valupChar = document.getElementById('upChar');
let valnumber = document.getElementById('number');
let valspeChar = document.getElementById('speChar');
let valeigChar = document.getElementById('eigChar');

function passwordvalidation(data){
const lowChar = RegExp('(?=.*[a-z])');
const upChar = RegExp('(?=.*[A-Z])');
const number = RegExp('(?=.*[0-9])');
const speChar = RegExp('(?=.*[!@#\$%\^&\*])');

if(lowChar.test(data)){
  vallowChar.classList.add('valid');
}else{
  vallowChar.classList.remove('valid');
}

if(upChar.test(data)){
  valupChar.classList.add('valid');
}else{
  valupChar.classList.remove('valid');
}

if(number.test(data)){
  valnumber.classList.add('valid');
}else{
  valnumber.classList.remove('valid');
}

if(speChar.test(data)){
  valspeChar.classList.add('valid');
}else{
  valspeChar.classList.remove('valid');
}

if(data.length >= 8){
  valeigChar.classList.add('valid');
}else{
  valeigChar.classList.remove('valid');
}
}
//End Password Validation

//Hide & Show Password  
showbtn.onclick = function(){
  if(passwordInput.value.length >= 1){
  if (passwordInput.type === 'password'){
     passwordInput.setAttribute('type', 'text');
     showbtn.classList.remove("fa-eye")
     showbtn.classList.add("fa-eye-slash")
   } else {
    passwordInput.setAttribute('type', 'password');
    showbtn.classList.remove("fa-eye-slash")
    showbtn.classList.add("fa-eye")
   }
  }
}
showbtn2.onclick = function(){
  if(confirmPasswordInput.value.length >= 1){
  if (confirmPasswordInput.type === 'password'){
     confirmPasswordInput.setAttribute('type', 'text');
     showbtn2.classList.remove("fa-eye")
     showbtn2.classList.add("fa-eye-slash")
   } else {
    confirmPasswordInput.setAttribute('type', 'password');
    showbtn2.classList.remove("fa-eye-slash")
    showbtn2.classList.add("fa-eye")
   }
  }
}
// Check input 
  const emptyUpdate = (inputReference, emptyErrorReference, otherErrorReference) => {
    if (!inputReference.value) {
      emptyErrorReference.classList.remove("hide");
      otherErrorReference.classList.add("hide");
      inputReference.classList.add("error");
    } else {
      emptyErrorReference.classList.add("hide");
    }
  };
  
  const errorUpdate = (inputReference, errorReference) => {
    errorReference.classList.remove("hide");
    inputReference.classList.remove("valid");
    inputReference.classList.add("error");
  };
  
  const validInput = (inputReference) => {
    inputReference.classList.remove("error");
    inputReference.classList.add("valid");
  };
  

  //Email
  emailInput.addEventListener("input", () => {
    if (emailVerify(emailInput.value)) {
      emailError.classList.add("hide");
      validInput(emailInput);
    } else {
      errorUpdate(emailInput, emailError);
      emptyUpdate(emailInput, emailEmpty, emailError);
    }
    
  });

  //User Name
  userNameInput.addEventListener("input", () => {
    if (textVerify(userNameInput.value)) {
      userNameError.classList.add("hide");
      validInput(userNameInput);
    } else {
      errorUpdate(userNameInput, userNameError);
      emptyUpdate(userNameInput, userNameEmpty, userNameError);
    }
  }); 
  

  //Password
  passwordInput.addEventListener("input", () => {
    if (passwordVerify(passwordInput.value)) {
      passwordError.classList.add("hide");
      validInput(passwordInput);
    } else {
      errorUpdate(passwordInput, passwordError);
      emptyUpdate(passwordInput, passwordEmpty, passwordError);
    }
  });
  var pass= document.getElementById("password_input");
  var mesg= document.getElementById("message");
  var strenght= document.getElementById("strenght");
  
  pass.addEventListener('input',()=>{
  
    if(pass.value.length >0){
      mesg.style.display = "block";
    }
    else {
      mesg.style.display = "none";
    }
    if (pass.value.length <=7) {
     strenght.innerHTML = "Weak";
    }
    else if (pass.value.length > 7 && pass.value.length < 10) {
      strenght.innerHTML = "Medium";
     }
      else if (pass.value.length >=10) {
        strenght.innerHTML = "Strong";
       }
  }) ;
  
  //Confirm_Password
  confirmPasswordInput.addEventListener("input", () => {
    if (confirmPasswordInput.value === "") {
    confirmPasswordEmpty.classList.remove("hide");
    confirmPasswordError.classList.add("hide");
    confirmPasswordInput.classList.add("error");
    } else if (confirmPasswordInput.value === passwordInput.value) {
    confirmPasswordError.classList.add("hide");
    validInput(confirmPasswordInput);
    } else {
    errorUpdate(confirmPasswordInput, confirmPasswordError);
    confirmPasswordEmpty.classList.add("hide");
    confirmPasswordInput.classList.remove("valid");
    }
    });

  
/* --------------- End Register Form Validation --------------------- */
