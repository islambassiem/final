@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endsection

@section('h1')
{{ __('head/staff.staff') }}
@endsection


@section('breadcrumb')
{{ __('head/staff.staff') .  ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="d-flex justify-content-end">
        <a href="{{ route('admin.employee.create') }}" class="btn btn-success mb-3">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </a>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Filter</h5>
        <form action="{{ route('admin.staff') }}" method="get">
          @csrf
          <div class="row">
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.status') }}</label>
                <select name="status" class="form-control js-example-basic-single">
                  <option value="" selected>{{ __('admin/staff.selectAll') }}</option>
                  <option value="1" {{ request()->get('status') == '1' ? 'selected' : '' }}>{{ __('admin/staff.active') }}</option>
                  <option value="0" {{ request()->get('status') == '0' ? 'selected' : '' }}>{{ __('admin/staff.resigned') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.gender') }}</label>
                <select name="gender" class="form-control">
                  <option value="" selected>{{ __('admin/staff.selectAll') }}</option>
                  @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" {{ request()->get('gender') == $gender->id ? 'selected' : '' }}>{{ $gender->{'gender' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.nationality') }}</label>
                <select name="nationality" class="form-control">
                  <option value="" selected>{{ __('admin/staff.selectAll') }}</option>
                  @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality->id }}" {{ request()->get('nationality') == $nationality->id ? 'selected' : '' }}>{{ $nationality->{'country' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.saudization') }}</label>
                <select name="saudization" class="form-control js-example-basic-single">
                  <option value="" selected>{{ __('admin/staff.selectAll') }}</option>
                  <option value="1" {{ request()->get('saudization') == '1' ? 'selected' : '' }}>{{ __('admin/staff.saudi') }}</option>
                  <option value="0" {{ request()->get('saudization') == '0' ? 'selected' : '' }}>{{ __('admin/staff.expat') }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label>{{ __('admin/staff.section') }}</label>
                <select name="section[]" class="form-control" multiple="">
                  @foreach ($sections as $section)
                    <option value="{{ $section->id }}" {{ request()->get('section') == $section->id ? 'selected' : ''}}>{{ $section->{'section' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label>{{ __('admin/staff.category') }}</label>
                <select name="category[]" class="form-control" multiple="multiple">
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->get('category') == $category->id ? 'selected' : ''}}>{{ $category->{'category' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label>{{ __('admin/staff.sponsorship') }}</label>
                <select name="sponsorship[]" class="form-control" multiple="multiple">
                  @foreach ($sponsorships as $sponsorship)
                    <option value="{{ $sponsorship->id }}" {{ request()->get('sponsorship') == $sponsorship->id ? 'selected' : ''}}>{{ $sponsorship->{'sponsorship' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.from') }}</label>
                <input type="date" name="from" class="form-control" value="{{ request()->get('from') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label>{{ __('admin/staff.to') }}</label>
                <input type="date" name="to" class="form-control" value="{{ request()->get('to') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="d-flex justify-content-between">
              <div>
                <a href="{{ route('admin.staff.download') }}" class="btn btn-success d-flex"><i class="bi bi-file-earmark-arrow-down-fill me-1"></i>{{ __('admin/staff.download') }}</a>
              </div>
              <div  class="d-flex justify-content-end">
                <a href="{{ route('admin.staff') }}" class="btn btn-danger d-flex"><i class="bi bi-x-lg me-1"></i> {{ __('admin/staff.clear') }}</a>
                <button type="submit" class="btn btn-primary mx-2 d-flex"><i class="bi bi-funnel me-1"></i> {{ __('admin/staff.filter') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card card-body">
      <div class="card-title">
        <h5 class="card-title">
          {{ __('head/staff.allStaff') }}
        </h5>
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{ __('admin/staff.empid') }}</th>
              <th scope="col">{{ __('head/staff.name') }}</th>
              <th scope="col">{{ __('admin/staff.iqama') }}</th>
              <th scope="col">{{ __('admin/staff.salary') }}</th>
              <th scope="col">{{ __('head/staff.ext') }}</th>
              <th scope="col">{{ __('head/staff.mobile') }}</th>
              <th scope="col">{{ __('admin/staff.email') }}</th>
              <th scope="col">{{ __('global.action') }}</th>
              {{-- <th scope="col">{{ __('global.action') }}</th> --}}
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($staff as $member)
              <tr>
                <td @if (! $member->active) class="text-danger" @endif>{{ $c }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->empid }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ session('_lang') == '_ar' ? $member->getFullArabicNameAttribute : $member->getFullEnglishNameAttribute }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->iqama($member->id)->document_id }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->latestSalary($member->id) }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->extension($member->id) }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->mobile($member->id) }}</td>
                <td @if (! $member->active) class="text-danger" @endif>{{ $member->email }}</td>
                <td @if (! $member->active) class="text-danger" @endif><a href="{{ route('admin.employee', $member) }}" class="btn btn-primary btn-sm py-0"><i class="bi bi-person-fill-gear"></i></a></td>
                {{-- <td>
                  <a href="" class="btn btn-primary btn-sm py-0"><i class="bi bi-stopwatch-fill"></i></a>
                  <a href=""class="btn btn-danger btn-sm py-0"><i class="bi bi-person-walking"></i></a>
                  <a href=""class="btn btn-secondary btn-sm py-0"><i class="bi bi-person-fill-gear"></i></a>
                </td> --}}
              </tr>
              @php $c++; @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection


@section('script')
<script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function (){
      $('select').select2();
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
      $('#actionModal').on('show.bs.modal', function (event){
      let button = $(event.relatedTarget);
      let id = button.data('id');
      let form = document.getElementById('actionForm');
      form.action = "vacations/action/" + id;
    });
    });
</script>
@endsection