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
                <div>{{ __('payslip.csm') }}</div>
                <div>{{ __('payslip.payslip') }}</div>
                <div>{{ date('F Y',strtotime($month)) }}</div>
              </div>
            </div>
            <div class="col-3 d-flex justify-content-center aling-items-center">
              <img src="{{ asset('assets/img/logo2.png') }}" alt="" class="payslip-logo">
            </div>
          </div>
          <div class="card-title py-0">
            Basic Information
          </div>
          <table class="basic-info">
            <thead></thead>
            <tbody>
              <tr>
                <td>Employee #</td>
                <td>{{ $user->empid }}</td>
                <td>Basic Salary</td>
                <td>{{ $user->basic($user->id) }}</td>
              </tr>
              <tr>
                <td>Employee Name</td>
                <td>{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</td>
                <td>Housing Allowance</td>
                <td>{{ $user->housing($user->id) }}</td>
              </tr>
              <tr>
                <td>Position</td>
                <td>{{ $user->position->{'position' . session('_lang')} }}</td>
                <td>Transportation Allowance</td>
                <td>{{ $user->transportation($user->id) }}</td>
              </tr>
              <tr>
                <td>Department</td>
                <td>{{ $user->section->{'section' . session('_lang')} }}</td>
                <td>Food Allowance</td>
                <td>{{ $user->food($user->id) }}</td>
              </tr>
              <tr>
                <td>IBAN</td>
                <td>{{ $user->bank($user->id)->iban }}</td>
                <td>Ticket Allowance</td>
                <td>{{ $user->ticket($user->id) }}</td>
              </tr>
              <tr>
                <td class="total">Total Package</td>
                <td></td>
                <td></td>
                <td>{{ $user->latestSalary($user->id) }}</td>
              </tr>
            </tbody>
            <tfoot></tfoot>
          </table>
          <h4 class="label">Calculated Statement for the period from {{ $start_date }} to {{ $end_date }} </h4>
          <div class="h4 text-bold underline">Attendance</div>
          <table class="payable days">
            {{-- <thead>
              <tr>
                <th colspan="4" style="padding-top:5px;padding-bottom:5px;">Attendance</th>
              </tr>
            </thead> --}}
            <tbody>
              <tr>
                <td>Working Days </td>
                <td>30</td>
                <td>Maternity</td>
                <td>0</td>
              </tr>
              <tr>
                <td>Annual Leave </td>
                <td>0</td>
                <td>Study</td>
                <td>0</td>
              </tr>
              <tr>
                <td>Business Leave</td>
                <td>0</td>
                <td>Parernity</td>
                <td>0</td>
              </tr>
              <tr>
                <td>Sick Leave</td>
                <td>0</td>
                <td>Pilgrimage</td>
                <td>0</td>
              </tr>
              <tr>
                <td>Death Leave</td>
                <td>0</td>
                <td>Marriage</td>
                <td>0</td>
              </tr>
              <tr>
                <td>Other</td>
                <td>0</td>
                <td></td>
                <td></td>
              </tr>
              <tr style="border-top: double 1px black">
                <td  style="color: red">Absent</td>
                <td  style="color: red">0</td>
                <td  style="color: red">Unpaid</td>
                <td  style="color: red">0</td>
              </tr>
            </tbody>
          </table>
          <h4 class="label">Payables - Deductables</h4>
          <table>
            <thead>
              <tr>
                <th class="text-center">Payables</th>
                <th class="text-center">Deductables</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:50%; vertical-align:baseline;">
                  <table class="other pay">
                    <tbody>
                      <tr>
                        <td>Paid Days</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <td>description</td>
                        <td>0</td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td style="width:50%; vertical-align:baseline;">
                  <table class="other ded">
                    <tbody>
                      <tr>
                        <td>GOSI</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <td>Upaid Days</td>
                        <td>0</td>
                      </tr>
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
                  <td style="text-align:right; font-size:20px; font-weight:bold;">8500.00</td>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="foot-img">
        <img src="{{ asset('assets/img/footer.png') }}" style="max-width: 100%"/>
      </div>
    </div>
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