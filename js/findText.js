var textfindChange = document.getElementById("TextFind");

function changeTextFind() {
  if (textfindChange.style.backgroundColor == 'white') {
    textfindChange.style.backgroundColor = '#fcf7f7';
    textfindChange.style.textAlign = 'center';
  }
  else {
    textfindChange.style.backgroundColor = 'white';
    textfindChange.style.textAlign = 'left';
  }
}

//엔터키 누르면
function press(){
  if(window.event.keyCode==13)
  {
    document.getElementById("nav-form").action ="./PickVi_text.php";
    document.getElementById("nav-form").submit();
  }
}
