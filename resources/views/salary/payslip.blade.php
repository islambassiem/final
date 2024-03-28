@extends('layout.master')

@section('title')
  {{ __('salary.salary') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/css/payslip.rtl.css') }}">
  @else
  <link rel="stylesheet" href="{{ asset('assets/css/payslip.css') }}">
  @endif
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
            {{ __('payslip.information') }}
          </div>
          <table class="basic-info">
            <thead></thead>
            <tbody>
              <tr>
                <td>{{ __('payslip.empid') }}</td>
                <td>{{ $user->empid }}</td>
                <td>{{ __('payslip.basic') }}</td>
                <td>{{ $salary->basic }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.name') }}</td>
                <td>{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</td>
                <td>{{ __('payslip.housing') }}</td>
                <td>{{ $salary->housing }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.position') }}</td>
                <td>{{ $user->position?->{'position' . session('_lang')} }}</td>
                <td>{{ __('payslip.trans') }}</td>
                <td>{{ $salary->transportation }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.department') }}</td>
                <td>{{ $user->section->{'section' . session('_lang')} }}</td>
                <td>{{ __('payslip.food') }}</td>
                <td>{{ $salary->food }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.iban') }}</td>
                <td>{{ $user->bank($user->id)->iban }}</td>
                <td>{{ __('payslip.ticket') }}</td>
                <td>{{ $user->ticket($user->id) }}</td>
              </tr>
              <tr>
                <td class="total">{{ __('payslip.package') }}</td>
                <td></td>
                <td></td>
                <td>{{ $package }}</td>
              </tr>
            </tbody>
            <tfoot></tfoot>
          </table>
          <h4 class="label">{{ __('payslip.calc') . ' ' . $start_date }} {{ __('payslip.to') }} {{ $end_date }} </h4>
          <div class="h4 text-bold underline">{{ __('payslip.attendance') }}</div>
          <table class="payable days">
            {{-- <thead>
              <tr>
                <th colspan="4" style="padding-top:5px;padding-bottom:5px;">Attendance</th>
              </tr>
            </thead> --}}
            <tbody>
              <tr>
                <td>{{ __('payslip.workingDays') }}</td>
                <td>{{ $workingDays }}</td>
                <td>{{ __('payslip.maternity') }}</td>
                <td>{{ $maternity }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.annual') }}</td>
                <td>{{ $annual }}</td>
                <td>{{ __('payslip.study') }}</td>
                <td>{{ $study }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.business') }}</td>
                <td>{{ $business }}</td>
                <td>{{ __('payslip.paternity') }}</td>
                <td>{{ $paternity }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.sick') }}</td>
                <td>{{ $sick }}</td>
                <td>{{ __('payslip.pilgrimage') }}</td>
                <td>{{ $pilgrimage }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.death') }}</td>
                <td>{{ $death }}</td>
                <td>{{ __('payslip.marriage') }}</td>
                <td>{{ $marriage }}</td>
              </tr>
              <tr>
                <td>{{ __('payslip.other') }}</td>
                <td>{{ $other }}</td>
                <td></td>
                <td></td>
              </tr>
              <tr style="border-top: double 1px black">
                <td  style="color: red">{{ __('payslip.absent') }}</td>
                <td  style="color: red">{{ $absent }}</td>
                <td  style="color: red">{{ __('payslip.unpaidDays') }}</td>
                <td  style="color: red">{{ $unpaid }}</td>
              </tr>
            </tbody>
          </table>
          <h4 class="label">{{ __('payslip.payDeduct') }}</h4>
          <table>
            <thead>
              <tr>
                <th class="text-center">{{ __('payslip.payables') }}</th>
                <th class="text-center">{{ __('payslip.deductables') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:50%; vertical-align:baseline;">
                  <table class="other pay">
                    <tbody>
                      <tr>
                        <td>{{ __('payslip.workingDays') }}</td>
                        <td>{{ $workingDaysAmount }}</td>
                      </tr>
                      @if ($paidDays > 0)
                        <tr>
                          <td>{{ __('payslip.paidDays') }}</td>
                          <td>{{ $paidDaysAmount }}</td>
                        </tr>
                      @endif
                        @if (count($payables) > 0)
                          @foreach ($payables as $payable)
                            <tr>
                              <td>{{ $payable->description }}</td>
                              <td>{{ $payable->amount }}</td>
                            </tr>
                          @endforeach
                        @endif
                    </tbody>
                  </table>
                </td>
                <td style="width:50%; vertical-align:baseline;">
                  <table class="other ded">
                    <tbody>
                      @if ($unpaidDaysAmount != 0)
                        <tr>
                          <td>{{ __('payslip.unpaidDays') }}</td>
                          <td>{{ $unpaidDaysAmount }}</td>
                        </tr>
                      @endif
                      @if (count($deductables) > 0 || $unpaidDaysAmount != 0)
                        @foreach ($deductables as $deductable)
                          <tr>
                            <td>{{ $deductable->description }}</td>
                            <td>{{ $deductable->amount }}</td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="2" style="text-align: center">{{ __('payslip.noDed') }}</td>
                        </tr>
                      @endif
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
                  <td style="font-size:20px;">{{ __('payslip.net') }}</td>
                  <td style="text-align:right; font-size:20px; font-weight:bold;">{{ $net }}</td>
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
    <button class="btn btn-primary" id="btn"><i class="bi bi-printer-fill"></i> {{ __('payslip.print') }}</button>
  </section>
@endsection

@section('script')
  <script>
    document.getElementById('btn').addEventListener("click", function(){
      window.print();
    });
  </script>
@endsection