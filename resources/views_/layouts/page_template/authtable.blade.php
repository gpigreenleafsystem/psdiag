
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!--<div>{{ Auth::user()->usertype }} </div>--!>

<div class="">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footer')
</div>
