
@extends('layouts.app', [
'namePage' => 'Edit appointment',
'class' => 'sidebar-mini',
'activePage' => 'editappointment',
])
@section('styles')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('node_modules/timepicker/jquery.timepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('node_modules/js-datepicker/datepicker.css')}}" - ->
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8  mr-auto">
                <div class="card card-signup text-center">
                    <div class="card-header ">
                        <h4 class="card-title">{{ __('Reschedule / Cancel Appointment') }}</h4>
                        <div class="card-body">
			    <form method="POST" action="{{route('updateappointment',['id' =>$apdetails->id])}}">
                                @csrf
                                <div> Patient Details: </div>
                                <!--Begin input name -->
                                <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        Patient Name:
                                    </div>
                                    <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Name') }}" type="text" name="name" value="{{ $patient->name }}" disabled>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient Age:
                                    </div>
                                    <input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age') }}" type="number" name="age" value="{{ $patient->age }}" disabled>
                                    @if ($errors->has('age'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient Gender:
                                    </div>
				    <input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age') }}" type="text" name="gender" value="{{ $patient->gender }}" disabled>
                                    @if ($errors->has('age'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <!--div class="input-group">
		<select class="form-control" name="gender">
		<option value="0">Select gender</option>
		<option value="male">Male</option>
		<option value="female">Female</option>
		</select>

	</div-->
                                <!--Begin input mobileno -->
                                <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient phNumber:
                                    </div>
                                    <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Mobileno') }}" type="number" name="mobileno" value="{{ $patient->mobileno }}" disabled>


                                    @if ($errors->has('mobileno'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('mobileno') }}</strong>
                                    </span>
                                    @endif
                                    <!--Begin input user type-->
                                </div>
                                <div class="input-group {{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient Address:
                                    </div>
                                    <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Address') }}" type="text" name="address" value="{{ $patient->address }}" disabled>
                                    @if ($errors->has('address'))

				    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div> Referer Details: </div>
                                <!--Begin input password -->
                                <div class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons users_single-02"></i>Doctor Name:
                                    </div>
                                    <input class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Name') }}" type="text" name="drname" value={{$referer->referer_name }} disabled>
                                    @if ($errors->has('drname'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('drname') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!--Begin input mobileno -->
                                <div class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons tech_mobile"></i>Doctor phNumber:
                                    </div>
                                    <input class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Mobileno') }}" type="number" name="drmobileno" value="{{ $referer->referer_phno }}" disabled>

                                </div>
                                <div> Appointment Details: </div>
                                <div class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        Appointment Date:
                                    </div>
                                    <input class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('DoctorMobileno') }}" type="text" name="drmobileno" value="{{ $apdetails->appointment_date }}" disabled>
                                </div>

				<div class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">


                                    <div class="input-group-text">
					Appointment Status: 
				
				   </div> 

<select name="appointmentstatus" id="appointmentstatus">
<option value="SCHEDULED" {{ $apdetails->appointment_status=='SCHEDULED'?'selected':''}}> SCHEDULED</option>
   <option value="RESCHEDULED" {{ $apdetails->appointment_status =='RESCHEDULED'?'selected':'' }}>RESCHEDULED</option>
    <option value="COMPLETED" {{ $apdetails->appointment_status=='COMPLETED'?'selected':'' }}>COMPLETED</option>
<option value="CANCELED" {{$apdetails->appointment_status=='CANCELED'?'selected':''}}>CANCELED</option>
</select>
                               </div>

                                <!--div class="input-group">
                                    <label for="datepicker1">Appointment Date:</label>
				    <div class="input-group date" id="datepicker" data-target-input="nearest">
                                        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input" name="selected_date" />
                                        <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
				</div-->
<div class="input-group">
    <label for="datepicker">Select Date:</label>
    <div class="input-group date" id="datepick" data-target-input="nearest">
        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"  name="selected_date" />
        <div class="input-group-append" data-target="#datepicker" >
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="input-group">
 <label for="time">Select Time:</label>
<div class="input-group" id="timediv" >
	<input type="text" id="time" class=" form-control bfh-timepicker"  name="selected_time" />
<div class="input-group-append" data-target="#time" >
            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
	</div>
</div>

                                <div class="card-footer ">
				    <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('SAVE')}}</button>
<a href="{{url('viewappointment')}}" class="btn  btn-round btn-lg">BACK</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection




<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <script>
        $(function() {
            $("#datetimepicker1").datetimepicker({
                format: 'DD/MM/YYYY HH:mm:ss',
                locale: 'en',
                sideBySide: true,
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right'
                }

            });
        });
    </script-->

@push('scripts')

<link href=
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'>
 
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
    </script>
 
    <script src=
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
<link rel="stylesheet"   
href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css"> 
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js"></script>

<script type="text/javascript">
    $(function () {
	    $('#datetimepicker1').datepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
    });
	    $('#time').timepicker({
        timeFormat: 'h:i a',
        interval: 30,
        minTime: '6:30am',
        maxTime: '10:00pm',
        defaultTime: '6:30',
        startTime: '6:30',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        disableTimeRanges: [
            ['12:00pm', '12:01pm']
        ]
    });

    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@endpush

































      
