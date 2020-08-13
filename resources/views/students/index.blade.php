@extends('layouts.app')

@section('title')
    Datatable
@endsection

@section('links')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">
                Student List
            </h3>
            <button class="btn btn-success pull-right create"><i class="glyphicon glyphicon-plus"></i> Create</button>

            <div class="dropdown">
              <button class="dropbtn"><i class="glyphicon glyphicon-export"></i> Export</button>
              <div class="dropdown-content">
                <a class="dropdown-item" href="{{ route('excel-file',['type'=>'xlsx']) }}">Download Excel</a>
                <a class="dropdown-item" href="{{ route('excel-file',['type'=>'csv']) }}">Download CSV</a>
              </div>
            </div>
            <div class="clearfix"></div>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table id="students-table" class="table" style="width:100% !important">
                <thead>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Mobile</td>
                    <td>Actions</td>
                </thead>
            </table>
        </div>

    </div>

    {{-- modal for add --}}
    <div id="modalAdd" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="store" action="{{url('students')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="studname">Full Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" required>
                        </div>
                         <div class="form-group">
                            <label for="email">Email id</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="uname">User Name</label>
                            <input type="uname" class="form-control" name="uname" placeholder="Enter user name" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="uname" class="form-control" name="mobile_number" placeholder="Enter Mobile Number" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="2000-1-1" >
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter address name" required>
                        </div>
                        <div class="form-group">
                            <label for="state">City</label>
                            <input type="text" class="form-control " name="city" placeholder="Enter city name" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control " name="state" placeholder="Enter State name" required>
                        </div>
                        <div class="form-group">
                            <label for="state">country</label>
                            <input type="text" class="form-control " name="country" placeholder="Enter State name" required>
                        </div>
                       <div class="form-group">
                            <label for="state">User profile pic</label>
                            <input type="file" class="form-control " name="user_image_path" placeholder="Enter State name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </form>
            </div>

        </div>
    </div>

    <div id="modalEdit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formupdate">
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label for="studname">Full Name</label>
                            <input type="text" class="form-control name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="studname">Email id</label>
                            <input type="text" class="form-control email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="studname">mobile Number</label>
                            <input type="text" class="form-control mobile_number" name="mobile_number" placeholder="Enter mobile number" required>
                        </div>

      <!--
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control status" name="status">
                              <option value="Sponsered">Sponsered</option>
                              <option value="Unsponsered">Unsponsered</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">District</label>
                            <input type="text" class="form-control district" name="district" placeholder="Enter district name" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control district" name="status" placeholder="Enter State name" required>
                        </div>-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
