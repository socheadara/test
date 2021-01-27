@extends('Layouts.master')
@section('header')
    <strong>Users</strong>
@endsection
@section('content')
    <div class="card card-gray">
        <div class="toolbox">
            <div class="row">
                <div class="col-sm-4">
                    @cancreate('user')
                        <a href="{{url('user/create')}}" class="btn btn-primary btn-sm btn-oval">
                            <i class="fa fa-plus-circle"></i> {{trans('label.create')}}
                        </a>
                    @endcancreate
                </div>
                <div class="col-sm-7">
                    <form class="search" action="{{url('user/search')}}" method="GET">
                        <input type="text" placeholder="Search by name , username ,email" name="us"  value="{{$us}}">
                        <button type="text"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
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
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('label.photo')}}</th>
                        <th>{{trans('label.name')}}</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Language</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $page = @$_GET['page'];
                        if(!$page)
                        {
                            $page = 1;
                        }
                        $i = config('app.row') * ($page-1) + 1;
                    ?>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>
                                <img src="{{asset($u->photo)}}" alt="" width="45" height="45">
                            </td>
                            <td>{{$u->name}}</td>
                            <td>{{$u->username}}</td>
                            <td>{{$u->email}}</td>
                            <td><a href="{{url('role/detail/'.$u->id)}}">{{$u->rname}}</a></td>
                            <td>
                                {{$u->language=='en'?'English':'ភាសាខ្មែរ'}}
                            </td>
                            <td class="action">
                                @candelete('user')
                                <a href="{{url('user/delete/'.$u->id)}}" class="text-danger" title="Delete" onclick="return confirm('Do you want to delete?') ">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endcandelete
                                &nbsp;
                                @canedit('user')
                                <a href="{{url('user/edit/'.$u->id)}}" class="text-success" title="edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcanedit
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->links()}}
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
            $('#menu_user').addClass('active');
        });
    </script>
@endsection
