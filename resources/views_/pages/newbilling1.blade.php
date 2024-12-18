@extends('layouts.app', [
'namePage' => 'Table List',
'class' => 'sidebar-mini',
'activePage' => 'table',
])

@section('styles')
<link href="app.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">
@endsection

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12  mr-auto">
                <div class="card card-signup text-center">
                    <div class="card-header ">
                        <h4 class="card-title">{{ __('Out Patient Bill') }}</h4>
                        <div class="card-body">
                            <form class="row " method="POST" action="{{ route('createnewbill') }}">
                                @csrf
                                <!-- Patient Details :-->
                                <div class="col-md-12 text-left"><b>Patient Details : </b>
                                </div>
                                <!-- Name-->
                                <div class="col-md-6 ">
                                    <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <div class="input-group-text" style="margin-right:2px;margin-top:5px;">
                                            Name
                                        </div>

                                        <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Name') }}" type="text" name="patient_name" value="{{ $patient->name }}"
					    disabled style="margin-left:5px;">
						<input type="hidden" name ="bill_pt_name" value="{{ $patient->name }}"/>
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                <!-- Contact No-->
                                <div class="col-md-6">
                                    <div class="input-group {{ $errors->has('mobileno') ? ' has-danger' : '' }}">
                                        <div class="input-group-text" style="margin-right:2px;margin-top:5px;">Contact
                                            No
                                        </div>
                                        <input class="form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Mobileno') }}" type="number" name="patient_mobileno"
                                            value="{{ $patient->mobileno }}" disabled style="margin-left:5px;">
					   <input type="hidden" name="bill_pt_no" value="{{$patient->mobileno}}"/>
					    @if ($errors->has('mobileno'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('mobileno') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Age-->
                                <div class="col-md-6">
                                    <div class="input-group {{ $errors->has('age') ? ' has-danger' : '' }}">
                                        <div class="input-group-text" style="margin-right:2px;margin-top:5px;"> Age
                                        </div>
                                        <input class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Age') }}" type="number" name="patient_age" value="{{ $patient->age }}"
					    disabled style="margin-left:5px;">
<input type="hidden" name="bill_pt_age" value="{{$patient->age}}"/>
                                        @if ($errors->has('age'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('age') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <!--Gender-->
                                <div class="col-md-6">
                                    <div class="input-group {{ $errors->has('gender') ? ' has-danger' : '' }}">
                                        <div class="input-group-text" style="margin-right:2px;margin-top:5px;">
                                            Gender
                                        </div>
                                        <input class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Gender') }}" type="text" name="patient_gender" value="{{ $patient->gender }}" disabled
					    style="margin-left:5px;">
<input type="hidden" name="bill_pt_gender" value="{{$patient->gender}}"/>
                                        @if ($errors->has('gender'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Address-->
                                <div class="col-12">
                                    <div class="input-group {{ $errors->has('address') ? ' has-danger' : '' }}">
                                        <div class="input-group-text" style="margin-right:2px;margin-top:5px;">
                                            Address
                                        </div>
                                        <input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Patient Address') }}" type="text" name="patient_address"
					    value="{{ $patient->address }}" disabled>
<input type="hidden" name="bill_pt_address" value="{{$patient->address}}"/>
                                        @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <!-- end of Patient Details-->
                                    <hr>
                                    <!-- Reffer Details-->
                                    <div class="col-md-12 text-left"><b>Referr Details : </b>
                                        <div class="row">
                                            <div class="col">
                                                <div
                                                    class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                                                    <div class="input-group-text"
                                                        style="margin-right:2px;margin-top:5px;">
                                                        Doctor Name
                                                    </div>
                                                    <input
                                                        class="form-control {{ $errors->has('drname') ? ' is-invalid' : '' }}"
                                                        placeholder="{{ __('Doctor Name') }}" type="text" name="drname"
                                                        value="{{$referer->referer_name }}" style="margin-left:5px;" disabled>
		<input type="hidden" name="bill_ref_name" value="{{$referer->referer_name}}"/>       
							@if ($errors->has('drname'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('drname') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col">
                                                <div
                                                    class="input-group {{ $errors->has('drmobileno') ? ' has-danger' : '' }}">
                                                    <div class="input-group-text"
                                                        style="margin-right:2px;margin-top:5px;">
                                                        Contact No
						    </div>
                                                    <input
                                                        class="form-control{{ $errors->has('drmobileno') ? ' is-invalid' : '' }}"
                                                        placeholder="{{ __('Doctor Mobileno') }}" type="number"
							name="drmobileno" value="{{ $referer->referer_phno }}" style="margin-left:5px;" disabled>
<input type="hidden" name="bill_ref_phno" value="{{$referer->referer_phno}}"/>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end of reffer details-->
                                        <hr>
                                        <!-- Appointmnet Details-->
                                        <div class="col-md-12 text-left"><b>Appointment Details: </b>
                                            <div class="row">
                                                <div class="col">
                                                    <div
                                                        class="input-group {{ $errors->has('drname') ? ' has-danger' : '' }}">
                                                        <div class="input-group-text"
                                                            style="margin-right:2px;margin-top:5px;">
                                                            Appointment Date
                                                        </div>
                                                        <input
                                                            class="form-control {{ $errors->has('apt_date') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Appointment Date') }}" type="text"
							    name="apt_date" value="{{ $apdetails->appointment_date }}" disabled style="margin-left:5px;">
<input type="hidden" name="bill_apt_date" value="{{$apdetails->appointment_date}}"/>
                                                        @if ($errors->has('apt_date'))
                                                        <span class="invalid-feedback" style="display: block;"
                                                            role="alert">
                                                            <strong>{{ $errors->first('apt_date') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col">
                                                    <div
                                                        class="input-group {{ $errors->has('apt_status') ? ' has-danger' : '' }}">
                                                        <div class="input-group-text"
                                                            style="margin-right:2px;margin-top:5px;">
                                                            Appointment Status:
                                                        </div>
                                                        <input
                                                            class="form-control{{ $errors->has('apt_status') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Appointment Status') }}" type="number"
                                                            name="apt_status" value="{{ $apdetails->appointment_status}}"  style="margin-left:5px;"
							    disabled>
<input type="hidden" name="bill_apt_status" value="{{$apdetails->appointment_status}}"/>

                                                    </div>
                                                </div>
                                            </div>
                                            <!--end of Appointment Details-->
                                            <hr>
					    <div class="col-md-12 text-left"><b>Investigation Details: </b></div>
<div class="col-md-12 text-right">
                                                <input type=button class="btn btn-primary" value="Add Investigation"
                                                    onclick=row()>
                                                <input type=button class="btn " value="Delete Investigation"
                                                    onclick=del()>
                                            </div>
                              <div class="card-body table-full-width table-responsive">
                                                    <table id="mytable" class="table">

                                                        <thead>
							    <th></th>
<th>Sl.No</th>

                                                            <th>Scan Type</th>
                                                            <th>Investigation</th>
                                                            <th>Rate</th>
                                                            <th>Qty</th>
                                                            <th>Discount</th>
                                                            <th>Amount</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>

                                                                <td><input type=checkbox></td>
                                                                <td><input name="slno" value="1"></td>

                                                                <td> <select name="inv_type1">
                                                                        <option value="CT">CT Scan </option>
                                                                        <option value="MRI">MRI Scan</option>
                                                                    </select></td>

                                                                <td>
                                                                    <select name="sub_inv_type1" class="form-select">
                                                                        <option value="Shoulder">Shoulder </option>
                                                                        <option value="Abdomen">Abdomen</option>
                                                                        <option value="pelvis">pelvis</option>

                                                                    </select>
                                                                </td>
                                                                <td><input name="rate1"></td>
                                                                <td><input name="qty1"></td>
                                                                <td><input name="discount1">
                                                                <td><input name="amount1"> </td>>

                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <input type="hidden" value="1" name="apt_no" id="apt_no" />


























</div>

 <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('ADD BILL')}}</button>

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script
>
<script>
function row() {
        var mytable = document.getElementById("mytable");
        var rows = mytable.rows.length;
        //alert(rows);
        var r = mytable.insertRow(rows);
        var c1 = r.insertCell(0);
        var c2 = r.insertCell(1);
        var c3 = r.insertCell(2);
        var c4 = r.insertCell(3);
        var c5 = r.insertCell(4);
        var c6 = r.insertCell(5);
        var c7= r.insertCell(6);
        var c8 = r.insertCell(7);
        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";


        var slno = document.createElement("input");
        var inv_type = document.createElement("select");
        // Use the Option constructor: args text, value, defaultSelected, selected
        var option = new Option('MRI_scan', 'MRI Scan', false, false);
        inv_type.appendChild(option);
        // Use createElement to add an option:
        option = document.createElement('option');
        option.value = 'CT_scan';
        option.text = 'CT Scan';
        inv_type.appendChild(option);
        inv_type.type = "select";
        var inv_name = "inv_type" + rows;
        inv_type.name = inv_name;

        //Sub_inv_type
        var sub_inv_type = document.createElement("select");
        // Use createElement to add an option:
        option = document.createElement('option');
        option.value = 'Shoulder';
        option.text = 'Shoulder';
        sub_inv_type.appendChild(option);
        sub_inv_type.type = "select";
        var sub_inv_name = "sub_inv_type" + rows;
        sub_inv_type.name = sub_inv_name;




        var amount = document.createElement("input");
        amount.type = "float"
        var amount_name = "amount" + rows;
        amount.name = amount_name;

        slno.type = "number";
        var slnoname = "slno" + rows;
        //alert(slnoname);
        slno.name = slnoname;
        slno.value = rows;

        var rate = document.createElement("input");
        rate.type = "float"
        var rate_name = "rate" + rows;
        rate.name = rate_name;

        var qty = document.createElement("input");
        qty.type = "float"
        var qty_name = "rate" + rows;
        qty.name = qty_name;

        var discount = document.createElement("input");
        discount.type = "int"
        var discount_name = "discount" + rows;
        discount.name = discount_name;



        c1.appendChild(checkbox);
        c2.appendChild(slno);
        c3.appendChild(inv_type);
        c4.appendChild(sub_inv_type);
        c5.appendChild(rate);
        c6.appendChild(qty);
        c7.appendChild(discount);
        c8.appendChild(amount);

        var value = document.getElementById("apt_no").value;
        document.getElementById("apt_no").value = rows;
}
 function del() {

        var mytable = document.getElementById("mytable");
        var rows = mytable.rows.length;
        //	if(rows==1){
        //		alert("You cannot delete this row");
        //	}
        for (var i = rows - 1; i > 0; i--) {
            if (mytable.rows[i].cells[0].children[0].checked) {
                mytable.deleteRow(i);
            }
        }
    }
    </script>


    @endpush
