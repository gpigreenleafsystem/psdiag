
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
            <div class="col-md-12 mr-auto">
                <div class="card card-signup text-center">
                    <div class="card-header ">
		<!--	<h4 class="card-title">{{ __('Edit Appointment') }}</h4>-->


<h4 class="card-tittle">{{__('Edit Appointment for ')}}  {{__('Scan')}}</h4>
			<div class="card-body">
			@if ($errors->any())
    			<div class="alert alert-danger">
       			 <ul>
            		@foreach ($errors->all() as $error)
                		<li>{{ $error }}</li>
            		@endforeach
        		</ul>
    			</div>
			@endif
			    <form method="POST" action="{{route('updateappointment',['id' =>$apdetails->id])}}">
                                @csrf
                                <div style="float:left;"> <h5>Patient Details:</h5> </div>
                                <!--Begin input name -->
                                <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        Patient Name:
                                    </div>
                                    <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Name') }}" type="text" name="name" value="{{ $patient->name }}" >
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient Age:
                                    </div>
                                    <input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age') }}" type="number" name="age" value="{{ $patient->age }}" >
                                    @if ($errors->has('age'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient Gender:
                                    </div>
				    <!--input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age') }}" type="text" name="gender" value="{{ $patient->gender }}" -->
<!--                                    @if ($errors->has('age'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif -->
                                </div>
                                <div class="input-group">
		<select class="form-control" name="gender">
		<option value="0">Select gender</option>
		<option value="Male" <?php if( $patient->gender =="Male" || $patient->gender =="male")echo " selected"?> >Male</option>
		<option value="Female" <?php if( $patient->gender =="Female" || $patient->gender =="female")echo " selected" ?>>Female</option>
		</select>

	</div>
                                <!--Begin input mobileno -->
                                <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                                    <div class="input-group-text" <i class="now-ui-icons tech_mobile"></i>Patient phNumber:
                                    </div>
                                    <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Mobileno') }}" type="number" name="mobileno" value="{{ $patient->mobileno }}" >


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
					    <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Address') }}" type="text" name="address" value="{{ $patient->address }}" >
                                    @if ($errors->has('address'))

				    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div style="flat:left;"><h5> Referer Details:</h5> </div>
                                <!--Begin input password -->
                                <div class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons users_single-02"></i>Doctor Name:
                                    </div>
                                    <input class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Name') }}" type="text" name="drname" value="{{$referer->referer_name }}" >
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
                                    <input class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Mobileno') }}" type="number" name="drmobileno" value="{{ $referer->referer_phno }}" >

                                </div>
				<div style"float:left;"><h5> Appointment Details:</h5> </div>

				    <div class="input-group">
<div class="input-group-text">Scan Type</div>

<select class="form-control" name="scan_type" id="scan_type">
<option value="1"
                                            {{ $apdetails->modality_id=='1'?'selected':''}}> CT
                                        </option>
                                        <option value="2"
                                            {{ $apdetails->modality_id=='2'?'selected':''}}> MRI
                                        </option>
    
</select>

</div>				
<div class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                                    <div class="input-group-text">
                                        Appointment Date:
				    </div>
                                    <input class="form-control{{ $errors->has('aptdate') ? ' is-invalid' : '' }}" placeholder="{{ __('appointment date') }}" type="text" name="aptdate" value="{{ \Carbon\Carbon::parse($apdetails->appointment_date)->format('d-m-Y H:i:s') }}" disabled>
                                </div>

				<div class="input-group {{ $errors->has('aptdate') ? ' has-danger' : '' }}">


                                    <div class="input-group-text">
					Appointment Status: 
				
                                    </div>

<select name="appointmentstatus" id="appointmentstatus">
                                        <option value="SCHEDULED"
                                            {{ $apdetails->appointment_status=='SCHEDULED'?'selected':''}}> SCHEDULED
                                        </option>
                                        <option value="RESCHEDULED"
                                            {{ $apdetails->appointment_status =='RESCHEDULED'?'selected':'' }}>
                                            RESCHEDULED</option>
                                        <option value="COMPLETED"
                                            {{ $apdetails->appointment_status=='COMPLETED'?'selected':'' }}>COMPLETED
                                        </option>
                                        <option value="CANCELED"
                                            {{$apdetails->appointment_status=='CANCELED'?'selected':''}}>CANCELED
                                        </option>
                                    </select>
                               </div>

                                <div class="input-group">
                                    <label for="datepicker" id="datelabel">Appointment Date:</label>
                                    <div class="input-group date" id="datepick" data-target-input="nearest">
                                        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input" name="selected_date" />
                                        <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
				</div>
<div class="input-group">
 <label for="time" id="timelabel">Select Time: (Please select 6:00 am for walkin appointments)</label>
<div class="input-group" id="timediv" >
	<input type="text" id="time" class=" form-control bfh-timepicker"  name="selected_time" />
<div class="input-group-append" data-target="#time" >
            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
	</div>
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
    @push('js')



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



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
	function convertDateString(dateString) {
    // Split the date string into parts
    var parts = dateString.split('/');

    // Rearrange and format the parts as yyyy-mm-dd
    var formattedDate = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');



    return formattedDate;
}
 function roundToNext30Minutes(date) {
        var minutes = date.getMinutes();
        var roundedMinutes = (Math.ceil(minutes / 30) * 30) % 60; // Round up to the next 30
        date.setMinutes(roundedMinutes);
        date.setSeconds(0);
        date.setMilliseconds(0);

        // If rounding pushed us to the next hour, increment the hour
        if (roundedMinutes === 0) {
          date.setHours(date.getHours() + 1);
        }

        return date;
      }


     $('#appointmentstatus').change(function() {
        if ($(this).val() === 'COMPLETED' ||  $(this).val() === 'CANCELED') {
            $('#datetimepicker1').closest('.input-group').hide();
	    $('#time').closest('.input-group').hide();
	    $('#timelabel').hide();
	     $('#datelabel').hide();
        } else {
            $('#datetimepicker1').closest('.input-group').show();
	    $('#time').closest('.input-group').show();
	    $('#timelabel').show();
	     $('#datelabel').show();
        }
    });

    // Trigger the change event on page load to handle pre-selected status
    $('#appointmentstatus').trigger('change');

    var pair = [];
var mintime='6:00am';
$(function () {
    var todaydate = new Date();
	    $('#datetimepicker1').datepicker({
	 //       formatDate: 'DD/MM/YYYY',
	   dateFormat: 'dd/mm/yy', 

	    startDate:new Date(),
		    minDate:todaydate,
		   onSelect: function(dateText) {
			   console.log("Selected date: " + convertDateString(dateText) + "; input's current value: " + this.value);
//	var selected = new Date(dateText);
			   var today = new Date();
			   var day = String(today.getDate()).padStart(2, '0'); // Get day (2 digits)
var month = String(today.getMonth() + 1).padStart(2, '0'); // Get month (2 digits, January is 0 so add 1)
var year = String(today.getFullYear()); // Get last 2 digits of the year

// Format to dd/mm/yy
var formattedDate = `${day}/${month}/${year}`;
          
          // Remove time information from today's date for comparison
          today.setHours(0, 0, 0, 0);
   pair=[];        
          // Check if selected date is today
          if (dateText == formattedDate) {
		  // If today, set minTime to current time
		  mintime = roundToNext30Minutes(new Date());
		  pair.push(["6:30",mintime]);
 //           $('#time').timepicker('option', 'minTime', mintime);
          } else {
		  // If future date, reset minTime
		  mintime='6:00am';
            $('#time').timepicker('option', 'minTime', '6:00am');
	  }

//initializeTimepicker(); 
	 $.ajax({
            type: "GET",
//          url: "/getappointmenttimes/"+convertDateString(dateText),
	    url: "/getappointmenttimes/"+convertDateString(dateText),	
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
	    success: function (response) {
		   // alert(response);
                for (var i = 0; i < response.length; i++) {
                    /*var hour = response.d[i].split(' ')[0].split(':')[0];
                    var min = parseInt(response.d[i].split(' ')[0].split(':')[1]) + 1;
                    min = min < 10 ? '0' + min : min;
                    var ampm = response.d[i].split(' ')[1];
                    var start = response.d[i];
		    var end = hour + ':' + min + ' ' + ampm;
		    pair.push([start, end]);*/
		//	alert(response[i]);
			pair.push(response[i]);

		}
		//pair.push(["7:30",mintime]);
		//alert(pair);
		initializeTimepicker();
            }
        });
		   },
		   
		  
});




initializeTimepicker();

});

function initializeTimepicker() {
 //   $('#time').timepicker('destroy'); // Destroy the existing timepicker instance
 $('#time').timepicker({
        timeFormat: 'h:i a',
        interval: 30,
        minTime: '6:00am',
        maxTime: '10:00pm',
        defaultTime: '6:30',
        startTime: '6:00am',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
       /* disableTimeRanges: [
            ['12:00pm', '12:01pm']
        ],*/
        'disableTimeRanges': pair
});

}


</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@endpush
