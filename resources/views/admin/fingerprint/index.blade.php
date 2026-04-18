@extends('admin.layout.master')

@section('title')
    {{ __('admin/salaries.fingerprint_transactions') }}
@endsection

@section('style')
    @if (session('dir') == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
@endsection

@section('h1')
    {{ __('admin/salaries.fingerprint_transactions') }}
@endsection

@section('breadcrumb')
    {{ __('admin/salaries.fingerprint_transactions')}}
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="card">
                <form action="{{ route('admin.fingerprint.filter') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title">{{ __('admin/salaries.fingerprint_transactions') }}</h5>
                        <div class="row align-items-center justify-content-between">
                            <div class="col-8 d-flex gap-4">
                                <div class="col-8 mb-3">
                                    <label for="user" class="form-label">{{ __('letters.employee') }}</label>
                                    <select class="form-select" id="user" name="empid" style="width:100%">
                                        <option selected disabled value="">{{ __('global.select') }}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->empid }}" @selected(old('user_id') == $user->id)>
                                                {{ $user->empid }} |
                                                {{ session('_lang') == '_en' ? $user->getFullEnglishNameAttribute : $user->getFullArabicNameAttribute }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="start_date" class="form-label">{{ __('head/vacations.from') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" />
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="end_date" class="form-label">{{ __('head/vacations.to') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end align-items-center ms-auto">
                                <button class="btn btn-primary">{{ __('head/vacations.filter') }}</button>
                            </div>
                        </div>
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
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection




@section('script')
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
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
            $('#table').dataTable({
                language: {
                    url: file
                }
            });
            $('#user').select2();
        });
    </script>
@endsection