@extends('layouts.app', [
    'namePage' => 'Appointment Calendar',
    'class' => 'sidebar-mini',
    'activePage' => 'Appointment Calendar',
  ])
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="container">
	<div class="row">
<div class="col-md-12  mr-auto">
                <div class="card card-signup text-center">
                    <div class="card-header ">
                        <h4 class="card-title">{{ __('Appointment Calendar') }}</h4>
                        <div class="card-body">
			<div id="calendar" style="overflow-x: scroll;  overflow-y: scroll;"></div>
</div>
</div>
</div>
        </div>
    </div>
</div>

    @endsection
    @push('scripts')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>

var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                    slotMinTime: '6:00:00',
                    slotMaxTime: '23:00:00',
		    events: @json($events),
		    headerToolbar: {
    left: 'prev,next',
    center: 'title',
    right: 'timeGridWeek,timeGridDay' // user can switch between the two
  }
            });
calendar.render();
calendar.setOption('height', 600);
    </script>
@endpush
@section('scripts')
@endsection
