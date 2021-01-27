@extends('Layouts.master')
@section('header')
    <strong>No Permission</strong>
@endsection
@section('content')
    <div class="card card-gray">
        <div class="toolbox">
            <a href="{{url('role')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
        </div>
        <div class="card-block">
            <p></p>
            <h3 class="text-danger">
                You do not has permission here!
            </h3>
        </div>
    </div>
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
