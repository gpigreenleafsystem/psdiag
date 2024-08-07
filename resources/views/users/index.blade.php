@extends('layouts.app', [
'namePage' => 'User List',
'class' => 'sidebar-mini',
'activePage' => 'users',
])

@section('content')
<div class="panel-header panel-header-sm"></div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary btn-round text-white pull-right" href="{{url('adduser')}}">Add user</a>
                    <div class="card-title">
                        <h5>Users List</h5>
                        <div class="col-12 mt-2">
                            @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('success')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>

                        <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="font-size: 1.05em; font-weight: 600; ">Name</th>
                                    <th style="font-size: 1.05em; font-weight: 600;">Email</th>
                                    <th style="font-size: 1.05em; font-weight: 600;">User type</th>
                                    <th style="font-size: 1.05em; font-weight: 600;" class="disabled-sorting text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->usertype }}</td>
                                    <td>
                                        <a href="{{url('edituser/'.$data->id)}}" class="btn btn-primary">Edit</a>
                                        @if($data->usertype !== 'ADMIN')
                                        <a href="{{url('deleteuser/'.$data->id)}}" class="btn">Delete</a>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
			</table>
{{$users->links()}}

                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!--div class="alert alert-danger">
      <span>
        <b></b> This is a PRO feature!</span>
    </div-->
        <!-- end row -->
    </div>
    <!-- <footer class="footer">
</footer>--!></div>                    </div>
@endsection
@section('scripts')
  <!--   Core JS Files   -->
    <script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets') }}/demo/demo.js"></script>
    @stack('js')
