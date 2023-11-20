$(document).ready(function(){
  var lang = "{{ session('lang') }}";
  var file;
  switch (lang) {
    case "ar":
      file = "{{ asset('assets/vendor/datatables/ar.json') }}"
      break;
    case "pk":
      file = "{{ asset('assets/vendor/datatables/pk.json') }}"
      break;
    case "in":
      file = "{{ asset('assets/vendor/datatables/in.json') }}"
      break;
    case "ph":
      file = "{{ asset('assets/vendor/datatables/ph.json') }}"
      break;
    default:
      file = "{{ asset('assets/vendor/datatables/en.json') }}"
      break;
  }
  console.log(file)
  $('#table').dataTable({
    language: {
      url: file
    }
  });
});