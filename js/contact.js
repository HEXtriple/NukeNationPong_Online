let email = document.getElementById("email");
let inputName = document.getElementById("name");
let subject = document.getElementById("subject");
let message = document.getElementById("message");
const REGEX = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

function formValidation(){
    checkIfEmpty(email);
    emailCheck(email);
    checkIfEmpty(inputName);
    checkIfEmpty(subject);
    checkIfEmpty(message);
}

function emailCheck (element) {
    
    if (element.value.match(REGEX)) {
        element.style.border = "solid green 0.4vw"
  
    }else{
        element.style.border = "solid red 0.4vw"
        element.placeholder = "Invalid email adress"
        alert("Invalid email adress")
    }
}

function checkIfEmpty(element){
    if(element.value.trim() == ""){
      element.style.border = "solid red 0.4vw"
      element.placeholder = "Space is empty"
    }else{
      element.style.border = "solid green 0.4vw"
      element.placeholder = "Please input here"
    }
}