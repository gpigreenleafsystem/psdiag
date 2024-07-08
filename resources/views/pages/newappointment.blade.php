@extends('layouts.app', [
    'namePage' => 'Table List',
    'class' => 'sidebar-mini',
    'activePage' => 'table',
  ])
@section('styles')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="col-md-8  mr-auto">
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
                  <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Name') }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
                  @if ($errors->has('name'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
		</div>

		<div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
		<input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Age') }}" type="number" name="age" value="{{ old('age') }}" required autofocus>
                  @if ($errors->has('age'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('age') }}</strong>
                    </span>
                  @endif
		</div>
	<div class="input-group">
		<select class="form-control" name="gender">
		<option value="0">Select gender</option>
		<option value="male">Male</option>
		<option value="female">Female</option>
		</select>

	</div>
                <!--Begin input mobileno -->
                <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons tech_mobile"></i>
                    </div>
                  </div>
                  <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Mobileno') }}" type="number" name="mobileno" value="{{ old('mobileno') }}" required>
                 
                 @if ($errors->has('mobileno'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('mobileno') }}</strong>
                    </span>
                @endif
		<!--Begin input user type-->
</div>
<div class="input-group {{ $errors->has('address') ? ' has-danger' : '' }}">
                <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Patient Address') }}" type="text" name="address" value="{{ old('address') }}" required autofocus>
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
                  <input class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Name') }}" type="text" name="drname" required>
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
                  <input class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor Mobileno') }}" type="number" name="drmobileno" value="{{ old('drmobileno') }}" required>

             <!--    @if ($errors->has('mobileno'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('mobileno') }}</strong>
                    </span>
                @endif
                <!--Begin input user type-->
</div>



<div class="input-group">
    <label for="datepicker">Select Date:</label>
    <div class="input-group date" id="datepick" data-target-input="nearest">
        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"  name="selected_date" />
        <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="input-group">
<!--div class="input-group-prepend">
<div class="inpu-group-text">
<i class="now-ui-icons users_single_02"></i
</div--!>

<select class="form-control" name="modality">

<option value="MRI SCAN">MRI SCAN</option>
<option value="CT SCAN">CT SCAN</option>
</select>

</div>
                <!--div class="form-check text-left">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox">
                    <span class="form-check-sign"></span>
                    {{ __('I agree to the') }}
                    <a href="#something">{{ __('terms and conditions') }}</a>.
                  </label>
                </div-->
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
@push('js')
 
<!-- Bootstrap Datepicker JavaScript - ->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>


  $('#datepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-crosshairs',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
    }
});-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script>
  $(function() {
    $( "#datetimepicker1" ).datetimepicker({
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
</script>

@endpush
