@extends('layout.master')

@section('title')
  {{ __('salary.salary') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/payslip.css') }}">
@endsection

@section('h1')
  {{ __('salary.salary') }}
@endsection

@section('breadcrumb')
  {{ __('salary.salary') . ' / '  . __('salary.payslip')}}
@endsection

@section('content')
  <section class="section">
    <div class="card" id="print">
      <div class="card-body">
        <div class="container-fluid">
          <div class="row mt-3">
            <div class="col-3 d-flex justify-content-center aling-items-center">
              <img src="{{ asset('assets/img/logo.png') }}" alt="" class="payslip-logo">
            </div>
            <div class="col-6 d-flex justify-content-center aling-items-center">
              <div class="card-title text-center">
                <div>Care and Science Medical Company</div>
                <div>Payslip</div>
                <div>{{ date('F Y',strtotime(now())) }}</div>
              </div>
            </div>
            <div class="col-3 d-flex justify-content-center aling-items-center">
              <img src="{{ asset('assets/img/logo2.png') }}" alt="" class="payslip-logo">
            </div>
          </div>
          <div class="card-title">
            Basic Information
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="card">
      <div class="card-body">
        <table class="basic-info">
          <thead></thead>
          <tbody>
            <tr>
              <td>Employee #</td>
              <td>$empid</td>
              <td>Basic Salary</td>
              <td>$basic</td>
            </tr>
            <tr>
              <td>Employee Name</td>
              <td>$name</td>
              <td>Housing Allowance</td>
              <td>$housing</td>
            </tr>
            <tr>
              <td>Position</td>
              <td>$position</td>
              <td>Transportation Allowance</td>
              <td>$transportation</td>
            </tr>
            <tr>
              <td>Department</td>
              <td>'. '$department' .'</td>
              <td>Food Allowance</td>
              <td>$food</td>
            </tr>
            <tr>
              <td>IBAN</td>
              <td>$iban</td>
              <td>Ticket Allowance</td>
              <td>$ticket '. '</td>
            </tr>
            <tr>
              <td class="total">Total Package</td>
              <td></td>
              <td></td>
              <td>$package</td>
            </tr>
          </tbody>
          <tfoot></tfoot>
        </table>
        <h4 class="label">Calculated Statement for the period from date(F,strtotime($startDate)) 21<sup>st</sup> date(Y,strtotime($startDate))' .' to date(F,strtotime($endDate)) 20<sup>th</sup> '. 'date(Y,strtotime($endDate))' .'</h4>
        <table class="payable days">
          <thead>
            <tr>
              <th colspan="4" style="padding-top:10px;padding-bottom:20px;">Paid Days</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Working Days </td>
              <td>'. '$total_working_days' .'</td>
              <td>Maternity</td>
              <td>'. $maternity .'</td>
            </tr>
            <tr>
              <td>Annual Leave </td>
              <td>'. '$annual' .'</td>
              <td>Study</td>
              <td>'. '$study' .'</td>
            </tr>
            <tr>
              <td>Business Leave</td>
              <td>'. '$business' .'</td>
              <td>Parernity</td>
              <td>'. '$paternity' .'</td>
            </tr>
            <tr>
              <td>Sick Leave</td>
              <td>'. '$sick' .'</td>
              <td>Pilgrimage</td>
              <td>'. $pilgrimage .'</td>
            </tr>
            <tr>
              <td>Death Leave</td>
              <td>'. '$death' .'</td>
              <td>Marriage</td>
              <td>'. '$marriage' .'</td>
            </tr>
            <tr>
              <td>Other</td>
              <td>'. '$other' .'</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <table class="deductable days">
          <thead>
            <tr>
              <th colspan="2" style="padding-top:10px;padding-bottom:20px;">Deductable Days</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Absent</td>
              <td>'. '$absent' .'</td>
            </tr>
            <tr>
              <td>Unpaid</td>
              <td>'. '$unpaid' .'</td>
            </tr>
          </tbody>
        </table>
        <h4 class="label">Other Payables - Deductables</h4>
        <table>
          <thead>
            <tr>
              <th>Payables</th>
              <th>Deductables</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width:50%; vertical-align:baseline;">
                <table class="other pay">
                  <tbody>
                    <tr>
                      <td>Paid Days</td>
                      <td>'. 'number_format($total_paid_days_amt,2)' .'</td>
                    </tr>';
                    '$total_payables = 0';
                    // foreach($payables as $p ){
                    // $total_payables += $p['amount'];
                    // $html .= '
                    // <tr>
                      // <td>' . $p['description'] . '</td>
                      // <td>'. number_format($p['amount'],2) .'</td>
                      // </tr>
                    // ';
                    // }
                  </tbody>
                </table>
              </td>
              <td style="width:50%; vertical-align:baseline;">
                <table class="other ded">
                  <tbody>
                    <tr>
                      <td>GOSI</td>
                      <td>'. 'number_format($gosi,2)' .'</td>
                    </tr>';
                    // if($total_unpaid_days > 0){
                    // $html .= '
                    // <tr>
                      // <td>Upaid Days</td>
                      // <td>'. number_format($total_unpaid_days,2) .'</td>
                      // </tr>
                    // ';
                    // }
                    // $total_deductables = $gosi ;
                    // foreach($deductables as $d){
                    // $total_deductables += $d['amount'];
                    // $html .= '
                    // <tr>
                      // <td>' . $d['description'] . '</td>
                      // <td>'. number_format($d['amount'],2) .'</td>
                      // </tr>
                    // ';
                    // }

                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="net">
          <table>
            <thead>
              <tr>
                <td style="font-size:20px;">Net Salary</td>
                <td style="text-align:right; font-size:20px; font-weight:bold;">'. 'number_format(round($total_paid_days_amt + $total_payables - $total_deductables,0),2)' .'</td>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div style="position: absolute; left:0; right: 0; bottom: 0;">
        <img src="{{ asset('assets/img/footer.png') }}" style="max-width: 100%"/>
      </div>
    </div> --}}
    <button class="btn btn-primary" id="btn">Print</button>
  </section>
@endsection

@section('script')
  <script>
    document.getElementById('btn').addEventListener("click", function(){
      window.print();
    });
  </script>
@endsection