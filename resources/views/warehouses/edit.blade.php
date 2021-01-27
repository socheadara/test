@extends('Layouts.master')
@section('header')
    <strong>Edit Warehouses</strong>
@endsection
@section('content')
<form action="{{route('warehouse.update', $wh->id)}}" method="POST">
    @method('PATCH')
    <div class="card card-gray">
        <div class="toolbox">
            <button class="btn btn-sm btn-primary btn-oval">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="{{url('warehouse')}}" class="btn btn-warning btn-sm btn-oval">
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
            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group row">
                        <label for="code"  class="col-sm-5">Code<span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="code" name="code" required autofocus value="{{$wh->code}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name"  class="col-sm-5"> Warehouse Name <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="name" name="name" required value="{{$wh->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address"  class="col-sm-5">Address</label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="address" name="address" required autofocus value="{{$wh->address}}">
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

            $('#menu_setting').addClass('active open');
            $('#setting_collapse').addClass('collapse in');
            $('#menu_warehouse').addClass('active');
        });

    </script>
@endsection
