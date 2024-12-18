
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!--<div>{{ Auth::user()->usertype }} </div>--!>
@include( Auth::user()->usertype  == 'ADMIN' ? 'layouts.navbars.sidebar' : 'layouts.navbars.sidebarnonadmin')

<div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footer')
</div>
