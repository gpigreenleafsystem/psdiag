<div class="sidebar" data-color="orange">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
    <div class="logo">
        <a href="" class="simple-text">
            <div style="font-size:15px"> {{ __('Padmashree Advanced') }}<br />
                {{__('Imaging Services')}}
            </div>
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
                    <p><strong>
                            {{ __("Manage User") }}
                            <b class="caret"></b>
                        </strong></p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="@if ($activePage == 'profile') active @endif">
                            <a href="{{ route('profile.edit') }}">
                                <i class="now-ui-icons users_single-02"></i>
                                <p> {{ __("User Profile") }} </p>
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravelExamplesappt">
                    <i class="fab fa-laravel"></i>
                    <p><strong>
                            {{ __("Manage Appointment") }}
                            <b class="caret"></b>
                        </strong></p>
                </a>
                <div class="collapse show" id="laravelExamplesappt">
                    <ul class="nav">
                        <li class="@if ($activePage == 'newappointment') active @endif">
                            <a href="{{ route('newappointment') }}">
                                <i class="now-ui-icons tech_watch-time"></i>
                                <p>{{ __('New Appointment') }}</p>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'viewappointment') active @endif">
                            <a href="{{ route('viewappointment') }}">
                                <i class="now-ui-icons tech_tv"></i>
                                <p>{{ __('View/Reschedule Appointments') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
                <a data-toggle="collapse" href="#laravelExamplesbilling">
                    <i class="fab fa-laravel"></i>
                    <p><strong>
                            {{ __("Manage Billing") }}
                            <b class="caret"></b>
                        </strong></p>
                </a>
                <div class="collapse show" id="laravelExamplesbilling">
                    <ul class="nav">
                        <li class="@if ($activePage == 'startbilling') active @endif">
                            <a href="{{ route('page.index','startbilling') }}">
                                <i class="now-ui-icons education_paper"></i>
                                <p>{{ __('Billing') }}</p>
                            </a>
                        </li>


                        <li class="@if ($activePage == 'billList') active @endif">
                            <a href="{{ route('billList') }}">
                                <i class="now-ui-icons business_money-coins"></i>
                                <p>{{ __('Manage Billing') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            <li>
               
               
            </li>
        </ul>
    </div>
</div>
