@extends('admin.layout.master')

@section('title')
    {{ __('admin/fingerprint.fingerprint') }}
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
@endsection

@section('h1')
    {{ __('admin/fingerprint.fingerprint') }}
@endsection

@section('breadcrumb')
    {{ __('admin/fingerprint.fingerprint')}}
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="card">
                <form action="{{ route('admin.fingerprint') }}" method="GET">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('admin/fingerprint.fingerprint') }}</h5>
                        <div class="row align-items-center justify-content-between">
                            <div class="col-8 d-flex gap-4">
                                <div class="col-8 mb-3">
                                    <label for="user" class="form-label">{{ __('admin/fingerprint.employee') }}</label>
                                    <select class="form-select" id="user" name="empid" style="width:100%">
                                        <option selected disabled value="">{{ __('global.select') }}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->empid }}" @selected(request('empid') == $user->empid)>
                                                {{ $user->empid }} |
                                                {{ session('_lang') == '_en' ? $user->getFullEnglishNameAttribute : $user->getFullArabicNameAttribute }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="start_date" class="form-label">{{ __('head/vacations.from') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ request()->has('start_date') ? request()->get('start_date') : \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="end_date" class="form-label">{{ __('head/vacations.to') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                        value="{{ request()->has('end_date') ? request()->get('end_date') : \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                </div>
                            </div>
                            <div class="col-1 d-flex justify-content-end align-items-center ms-auto">
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('admin/fingerprint.fingerprint') }}</h5>
                    @if (!request()->has('empid'))
                        <div class="alert alert-danger my-5" role="alert">
                            {{ __('admin/fingerprint.noFingerprint') }}
                        </div>
                    @endif
                    @if (request()->has('empid'))
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin/fingerprint.empid') }}</th>
                                    <th scope="col">{{ __('admin/fingerprint.name') }}</th>
                                    <th scope="col">{{ __('admin/fingerprint.date') }}</th>
                                    <th scope="col">{{ __('admin/fingerprint.checkin') }}</th>
                                    <th scope="col">{{ __('admin/fingerprint.checkout') }}</th>
                                    <th scope="col">{{ __('admin/fingerprint.period') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($period as $date)
                                    @php
                                        $formatted = $date->format('Y-m-d');
                                        $record = $fingerprint[$formatted] ?? null;
                                        $checkIn = Carbon\Carbon::parse($record?->checkin);
                                        $checkout = Carbon\Carbon::parse($record?->checkout);
                                        $diff = $checkIn?->diffAsCarbonInterval($checkout)
                                    @endphp
                                    @if ($record)
                                        <tr>
                                            <td>{{ $record->empid }}</td>
                                            <td>{{ session('_lang') == '_ar' ? $record->name_ar : $record->name_en }}</td>
                                            <td>{{ $formatted }}</td>
                                            <td>{{ Carbon\Carbon::parse($record->checkin)->format('H:i:s') }}</td>
                                            <td>{{ $checkIn == $checkout ? '--' : Carbon\Carbon::parse($record->checkout)->format('H:i:s') }}
                                            </td>
                                            <td>{{ $checkIn->diffInSeconds($checkout) > 0 ? $diff : '--'}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $empid }}</td>
                                            <td>{{ session('_lang') == '_en' ? $employee?->getFullEnglishNameAttribute : $employee?->getFullArabicNameAttribute }}
                                            </td>
                                            <td>{{ $formatted }}</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td colspan="2" class="text-danger">
                                                {{ __('admin/fingerprint.absent') }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection




@section('script')
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#user').select2();
        });
    </script>
@endsection