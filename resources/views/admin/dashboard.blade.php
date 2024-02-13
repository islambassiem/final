@extends('admin.layout.master')


@section('title')
  {{ __('dashboard.dashboard') }}
@endsection

@section('h1')
{{ __('dashboard.dashboard') }}
@endsection


@section('breadcrumb')
{{ __('dashboard.dashboard') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          Employees Numbers
        </h5>
        <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/js/loader.js') }}"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable({{ Js::from($results) }});
      var options = {
        title: 'My Daily Activities',
        is3D: true,
      }
      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      google.visualization.events.addListener(chart, 'select', function () {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          // Redirect to another page with query parameters
          var selectedValue = data.getValue(selectedItem.row, 0); // Assuming you have a single column in your DataTable
          window.location.href = 'your_destination_page.php?param=' + selectedValue;
        }
      });
      chart.draw(data, options);
    }
  </script>
@endsection