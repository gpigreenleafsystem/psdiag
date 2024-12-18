@extends('layouts.app', [
    'namePage' => 'New Appointment',
    'class' => 'sidebar-mini',
    'activePage' => 'newappointment',
  ])
@section('styles')
<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<!--link rel="stylesheet" type="text/css" href="{{asset('node_modules/timepicker/jquery.timepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('node_modules/js-datepicker/datepicker.css')}}"- ->
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" /-->
@endsection
@section('content')
<div class="panel-header panel-header-sm">
  </div>
 <div class="content">
    <div class="container">
      <div class="row">
        <!--div class="col-md-5 ml-auto">
          <!--div class="info-area info-horizontal mt-5">
            <div class="icon icon-primary">
              <i class="now-ui-icons media-2_sound-wave"></i>
            </div>
            <div class="description">
              <h5 class="info-title">{{ __('Marketing') }}</h5>
              <p class="description">
                {{ __("We've created the marketing campaign of the website. It was a very interesting collaboration.") }}
              </p>
            </div>
          </div>
          <div class="info-area info-horizontal">
            <div class="icon icon-primary">
              <i class="now-ui-icons media-1_button-pause"></i>
            </div>
            <div class="description">
              <h5 class="info-title">{{ __('Fully Coded in HTML5') }}</h5>
              <p class="description">
                {{ __("We've developed the website with HTML5 and CSS3. The client has access to the code using GitHub.") }}
              </p>
            </div>
          </div!-->
          <!--div class="info-area info-horizontal">
            <div class="icon icon-info">
              <i class="now-ui-icons users_single-02"></i>
            </div>
            <div class="description">
              <h5 class="info-title">{{ __('Built Audience') }}</h5>
              <p class="description">
                {{ __('There is also a Fully Customizable CMS Admin Dashboard for this product.') }}
              </p>
            </div->
          </div!- ->
        </div-->
        <div class="col-md-12  mr-auto">
          <div class="card card-signup text-center">
            <div class="card-header ">
              <h4 class="card-title">{{ __('Add New Appointment') }}</h4>
            <div class="card-body">
              <form method="POST" action="{{ route('addappointment') }}">
                @csrf
                <!--Begin input name -->
                <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Name*') }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
                  @if ($errors->has('name'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
		</div>

		<div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
		<input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age*') }}" type="number" name="age" value="{{ old('age') }}" required autofocus>
                  @if ($errors->has('age'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('age') }}</strong>
                    </span>
                  @endif
		</div>
	<div class="input-group">
		<select class="form-control" name="gender">
		<option value="0">Select gender*</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		</select>

	</div>
                <!--Begin input mobileno -->
                <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons tech_mobile"></i>
                    </div>
                  </div>
                  <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Mobileno*') }}" type="number" name="mobileno" value="{{ old('mobileno') }}" required>
                 
                 @if ($errors->has('mobileno'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('mobileno') }}</strong>
                    </span>
                @endif
		<!--Begin input user type-->
</div>
<div class="input-group {{ $errors->has('address') ? ' has-danger' : '' }}">
                <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Address*') }}" type="text" name="address" value="{{ old('address') }}" required autofocus>
                  @if ($errors->has('address'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('address') }}</strong>
                    </span>
                  @endif
</div>

                <!--Begin input password -->
                <div class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_single-02"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Name*') }}" type="text" name="drname" id="drname" required>
                  @if ($errors->has('drname'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('drname') }}</strong>
                    </span>
                  @endif
		</div>

<!--Begin input mobileno -->
                <div class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons tech_mobile"></i>
                    </div>
                  </div>
                  <input class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Mobileno') }}" type="number" name="drmobileno" value="{{ old('drmobileno') }}" >

             <!--    @if ($errors->has('mobileno'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('mobileno') }}</strong>
                    </span>
                @endif
                <!--Begin input user type-->
</div>



<div class="input-group">
    <label for="datepicker">* Select Date:</label>
    <div class="input-group date" id="datepick" data-target-input="nearest">
        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"  name="selected_date" />
        <div class="input-group-append" data-target="#datepicker" >
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="input-group">
 <label for="time">Select Time*: (Please select 6:00 am for walkin appointments)</label>
<div class="input-group" id="timediv" >
	<input type="text" id="time" class=" form-control bfh-timepicker"  name="selected_time" />
<div class="input-group-append" data-target="#time" >
            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
	</div>
</div>
<!--select class="form-control scan-type" id="starttimesel" name="starttimesel" onchange="">
                        <option value="">Select Time</option>
                        <option value="630">6:30</option>
		    </select-->
</div>
<div class="input-group">


<select class="form-control" name="modality">

<option value="MR">MRI SCAN</option>
<option value="CT">CT SCAN</option>
</select>

</div>
                <div class="card-footer ">
                  <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('ADD APPOINTMENT')}}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
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

	var hours = date.getHours();
    var mins = date.getMinutes();
    var formattedTime = (hours < 10 ? '0' + hours : hours) + ':' + (mins < 10 ? '0' + mins : mins);

    return formattedTime;

      //  return date;
      }
var pair = [];
var mintime='6:00am';
$(function () {
	 $("#drname").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('autocomplete.doctor') }}",
                    data: {
                        query: request.term
                    },
			    success: function(data) {
				   // alert(data);
                        response(data);
                    }
                });
            },
            minLength: 2, // Minimum characters before triggering the search
            select: function(event, ui) {
                // You can do something with the selected value if needed
                $('#drname').val(ui.item.value);
                return false;
            }
        });

//	var pair = [];
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

/*$('#time').on('click', function () {
	//if()
        var now = new Date();
        $(this).timepicker('option', 'minTime', now);
      });
 */



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
