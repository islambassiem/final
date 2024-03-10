<a href="{{ route('admin.salaries') }}">{{ __('admin/salaries.salaries') }}</a>
<span> / </span>
<a href="{{ route('admin.salaries.working', $month_id) }}">{{ __('admin/salaries.workingDays') }}</a>
<span> / </span>
<a href="{{ route('admin.salaries.non.working', $month_id) }}">{{   __('admin/salaries.nonWorkingDays') }}</a>
<span> / </span>
<a href="{{ route('admin.salaries.payables', $month_id) }}">{{   __('admin/salaries.payables') }}</a>
<span> / </span>
<a href="{{ route('admin.salaries.deductables', $month_id) }}">{{   __('admin/salaries.deductables') }}</a>