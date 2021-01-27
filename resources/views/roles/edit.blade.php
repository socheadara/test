@extends('Layouts.master')
@section('header')
    <strong>Edit Roles</strong>
@endsection
@section('content')
<form action="{{url('role/update')}}" method="POST" >
    <div class="card card-gray">
        <div class="toolbox">
            <button class="btn btn-sm btn-primary btn-oval">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="{{url('role')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
        </div>
        <div class="card-block">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>
                        {{session('success')}}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>
                        {{session('error')}}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   <ul>
                       @foreach ($errors->all() as $error)
                           <li>{{$error}}</li>
                       @endforeach
                   </ul>
                </div>
            @endif
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$role->id}}">
            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group row">
                        <label for="name"  class="col-sm-3"> Role Name <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="name" name="name" required autofocus value="{{$role->name}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#sidebar-menu').removeClass('active open');
            $('#sidebar-menu li ul li').removeClass('active');

            $('#menu_security').addClass('active open');
            $('#security_collapse').addClass('collapse in');
            $('#menu_role').addClass('active');
        });

    </script>
@endsection
