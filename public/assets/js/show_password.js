var eyeOpen = document.getElementById('eye-open');
var eyeClosed = document.getElementById('eye-closed');
var password = document.getElementsByName('password');


eyeClosed.addEventListener('click', function(){
  this.style.display = "none";
  eyeOpen.style.display = "block";
  password[0].type = 'text';
});

eyeOpen.addEventListener('click', function(){
  this.style.display = "none";
  eyeClosed.style.display = "block";
  password[0].type = 'password';
});

