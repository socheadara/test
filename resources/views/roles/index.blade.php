@extends('Layouts.master')
@section('header')
    <strong>Roles</strong>
@endsection
@section('content')
    <div class="card card-gray">
        <div class="toolbox">
            <div class="row">
                <div class="col-sm-4">
                    @cancreate('role')
                        <a href="{{url('role/create')}}" class="btn btn-primary btn-sm btn-oval">
                            <i class="fa fa-plus-circle"></i> Create
                        </a>
                    @endcancreate
                </div>
                <div class="col-sm-7">
                    <form class="search" action="{{url('role/search')}}" method="GET">
                        <input type="text" placeholder="Search by name" name="ro"  value="{{$ro}}">
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
                        <th>Name</th>
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
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>
                                <a href="{{url('role/detail/'.$role->id)}}">{{$role->name}}</a>
                            </td>

                            <td class="action">
                                @candelete('role')
                                <a href="{{url('role/delete/'.$role->id)}}" class="text-danger" title="Delete" onclick="return confirm('Do you want to delete?') ">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endcandelete
                                &nbsp;
                                @canedit('role')
                                <a href="{{url('role/edit/'.$role->id)}}" class="text-success" title="edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcanedit
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$roles->links()}}
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
