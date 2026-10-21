@extends('layout.master')

@section('title')
    {{ __('Payroll') }}
@endsection


@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection


@section('h1')
    {{ __('Payroll') }}
@endsection

@section('breadcrumb')
    {{ __('payroll') }}
@endsection




@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <section class="section">
        @if ($month)
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card margin-auto">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Process the salary') }}</h5>
                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ route('timesheet', $month->id) }}"
                                    class="d-block bg-primary text-white p-2 text-decoration-none">Timesheet</a>
                                <a href="{{ route('paydeduct', $month->id) }}"
                                    class="d-block bg-success text-white p-2 text-decoration-none">Payables and
                                    Deductables</a>
                            </div>
                            <hr>
                            <form action="{{ route('payroll.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row" id="addAttachment">
                                    <div class="col-12">
                                        <label for="attachment"
                                            class="col-sm-12 col-form-label">{{ __('Main File JD Edward') }}</label>
                                        <div class="col-sm-12">
                                            <input type="file" class="dropify" id="attachment" name="attachment"
                                                data-height="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">{{ __('global.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger my-5" role="alert">
                The month is not open yet
            </div>
        @endif
    </section>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#vacation_type").select2();

            $('.dropify').dropify({
                messages: {
                    'default': "",
                    'replace': "{{ __('global.dnd') }}",
                    'remove': "{{ __('global.del') }}",
                    'error': "{{ __('global.error') }}"
                }
            });

            let max = "{{ __('global.max') }}";
            let count = document.getElementById('letters_count');
            let notes = document.getElementById('notes');
            notes.addEventListener('keyup', function() {
                let char = this.value.length;
                count.innerHTML = `${max} ${char} / 255`;
            });
            count.innerHTML = `${max} ${notes.value.length} / 255`;

            $('#vacation_type').on('change', function() {
                if ($(this).val() == 2) {
                    Swal.fire({
                        title: "{{ __('vacations.sick_leave') }}",
                        icon: "question",
                        html: `
              <div>
                <img src="{{ asset('assets/img/seha.png') }}" alt="Seha" style="width: auto; height: 300px;">
                <p>{{ __('vacations.seha') }}</p>
              </div>
            `,
                        // imageHeight: 300,
                        // imageAlt: "A tall image",
                        // imageUrl: "{{ asset('assets/img/seha.png') }}"
                    });
                }
            });
        });
    </script>
@endsection
