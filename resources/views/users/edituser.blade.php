@extends('layouts.app', [
    'namePage' => 'Edit User ',
'class' => 'sidebar-mini',
    'activePage' => 'Edit User',
    'backgroundImage' => asset('assets') . "/img/bgnew.jpg",
])
@section('content')
<div class="panel-header panel-header-sm"></div>
  <div class="content">
    <div class="container">
      <div class="row">

        <div class="col-md-12  ">
          <div class="card card-signup text-center">
            <div class="card-header ">
	      <h4 class="card-title">{{ __('Edit User') }}</h4>

            <div class="card-body ">
              <form method="POST" action="{{route('updateuser',['id' =>$user->id])}}">
	      @csrf
	      
                <!--Begin input name -->
                <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" type="text" name="name" value="{{ $user->name }}" required autofocus>
                  @if ($errors->has('name'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
                <!--Begin input email -->
                <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons ui-1_email-85"></i>
                    </div>
                  </div>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{$user->email}}" required>
                 </div>
                 @if ($errors->has('email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
		<!--Begin input user type-->


                <!--Begin input password -->
                <div class="input-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons objects_key-25"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" type="password" name="password" value="{{$user->password}}" onchange="enableeditpwd()" required>
                  @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
                <!--Begin input confirm password -->
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons objects_key-25"></i></i>
                    </div>
                  </div>
                  <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" value="{{$user->password}}"  required>
		</div>
<div class="input-group">
<select  class="form-control" name="usertype" >
<option value="TECHNICIAN" {{$user->usertype=='TECHNICAN'?'selected':''}}>Technician</option>
<option value="FRONTDESK"{{$user->usertype=='FRONTDESK'?'selected':''}}>Front Desk</option>
<option value="LEADFRONTDESK"{{$user->usertype=='LEADFRONTDESK'?'selected':''}}>Lead Front Desk</option>
<option value="ADMIN" {{$user->usertype=='ADMIN'?'selected':''}}>Admin</option>
</select>

</div>
  <input type="hidden" name="pwdedited" id="pwdedited" value="0">
                <div class="card-footer ">
		  <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('SAVE')}}</button>
<a href="{{url('usermanagement')}}" class="btn btn-danger btn-round btn-lg">Back</a>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
  <script>
    function enableeditpwd() {
        event.preventDefault(); // Prevent form submission
        document.getElementById('pwdedited').value = 1;
    }
    </script>


