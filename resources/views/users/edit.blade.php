@extends('Layouts.master')
@section('header')
    <strong>Edit Users</strong>
@endsection
@section('content')
<form action="{{url('user/update')}}" method="POST" enctype="multipart/form-data">
    <div class="card card-gray">
        <div class="toolbox">
            <button class="btn btn-sm btn-primary btn-oval">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="{{url('user')}}" class="btn btn-warning btn-sm btn-oval">
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
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group row">
                        <label for="name"  class="col-sm-3"> Full Name <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="name" name="name" required autofocus value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3"> Email <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="email"  class="form-control" id="email" name="email" required value="{{$user->email}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Username <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="username" name="username" required value="{{$user->username}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-7 nth">
                            <p class="small-text">Keep it blank to uses the old password </p>
                            <input type="password"  class="form-control" id="password" name="password" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-3 ">Role <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select name="role" id="role" class="form-control chosen-select">
                                <option value="">-----Select-----</option>
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}" {{$user->role_id==$role->id?'selected':''}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="language" class="col-sm-3 ">Language <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select name="language" id="language" class="form-control">
                                <option value="en" {{$user->language=='en'?'selected':''}}>English</option>
                                <option value="km" {{$user->language=='km'?'selected':''}}>ភាសាខ្មែរ</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group row">
                        <label for="photo" class="col-sm-3">Photo</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="photo" name="photo"
                                   onchange="preview(event)" accept="image/x-png,image/gif,image/jpeg" >
                            <p style="margin-top: 9px">
                                <img src="{{asset($user->photo)}}" alt="" width="120" id="img">
                            </p>
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
            $('#menu_user').addClass('active');
        });
        function preview(evt)
        {
            let img = document.getElementById('img');
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    </script>
@endsection
