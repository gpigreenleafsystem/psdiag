<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="" class="simple-text">
      {{ __('Padmashree Diagnostics') }}
    </a>
    <a href="" class="card-title"> <!--class="simple-text  justify-content-center"-->
      {{ __('Billing') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li>
        <a data-toggle="collapse" href="#laravelExamples">
            <i class="fab fa-laravel"></i>
          <p>
            {{ __("Manage User") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExamples">
          <ul class="nav">
            <li class="@if ($activePage == 'profile') active @endif">
              <a href="{{ route('profile.edit') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("User Profile") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'users') active @endif">
              <a href="{{ route('usermanagement') }}">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p> {{ __("User Management") }} </p>
              </a>
            </li>
          </ul>
	</div>
	<a data-toggle="collapse" href="#laravelExamplesappt">
            <i class="fab fa-laravel"></i>
          <p>
            {{ __("Manage Appointment") }}
            <b class="caret"></b>
          </p>
        </a>
	<div class="collapse show" id="laravelExamplesappt">
	<ul class="nav">
      <li class="@if ($activePage == 'newappointment') active @endif">
        <a href="{{ route('newappointment') }}">
          <i class="now-ui-icons tech_watch-time"></i>
          <p>{{ __('New Appointment') }}</p>
        </a>
      </li>
	<li class="@if ($activePage == 'newappointment') active @endif">
        <a href="{{ route('viewappointment') }}">
	  <i class="now-ui-icons tech_tv"></i>
          <p>{{ __('View Appointments') }}</p>
        </a>
      </li>
	<li class="@if ($activePage == 'newappointment') active @endif">
        <a href="{{ route('viewappointment') }}">
          <i class="now-ui-icons ui-2_time-alarm"></i>
          <p>{{ __('Reshcedule/Cancel  Appntmnt') }}</p>
        </a>
      </li>
 	</ul>
        </div>
      <li class = "@if ($activePage == 'startbilling') active @endif">
        <a href="{{ route('page.index','startbilling') }}">
          <i class="now-ui-icons education_paper"></i>
          <p>{{ __('Billing') }}</p>
        </a>
      </li>
	<li class="@if ($activePage == 'investigations') active @endif">
	<a href="{{ route('investigations') }}">
          <i class="now-ui-icons media-2_sound-wave"></i>
          <p>{{ __('Investigations') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'notifications') active @endif">
        <a href="{{ route('page.index','notifications') }}">
          <i class="now-ui-icons files_single-copy-04"></i>
          <p>{{ __('Reports') }}</p>
        </a>
      </li>
<!--li class = " @if ($activePage == 'table') active @endif">
        <a href="{{ route('page.index','tabletest') }}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>{{ __('Table Test') }}</p>
        </a>
      </li-->
    </ul>
  </div>
</div>
