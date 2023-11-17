$('select').select2();

document.getElementById('next1').addEventListener('click', () => {
  document.getElementById('phase1').style.display = "none";
  document.getElementById('phase2').style.display = "block";
  document.getElementById('progressBar').style.width = "66%";
  document.getElementById('progressBar').innerHTML = "66%";
});

document.getElementById('back1').addEventListener('click', () => {
  document.getElementById('phase2').style.display = "none";
  document.getElementById('phase1').style.display = "flex";
  document.getElementById('progressBar').style.width = "33%"
  document.getElementById('progressBar').innerHTML = "33%";
});

document.getElementById('next2').addEventListener('click', () => {
  document.getElementById('phase2').style.display = "none";
  document.getElementById('phase3').style.display = "flex";
  document.getElementById('progressBar').style.width = "100%"
  document.getElementById('progressBar').innerHTML = "100%";
});

document.getElementById('back2').addEventListener('click', () => {
  document.getElementById('phase3').style.display = "none";
  document.getElementById('phase2').style.display = "block";
  document.getElementById('progressBar').style.width = "66%"
  document.getElementById('progressBar').innerHTML = "66%";
});

document.getElementById('submit').addEventListener('click', function(){
  document.getElementsByTagName('form')[0].submit();
});