@extends('Layouts.master')
@section('header')
    <strong>Stock Out</strong>
@endsection
@section('content')
    <div class="card card-gray">
        <div class="toolbox">
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{route('stock-out.create')}}" class="btn btn-primary btn-sm btn-oval">
                        <i class="fa fa-plus-circle"></i> Create
                    </a>
                </div>
                <div class="col-sm-6">
                    <form class="search" action="{{url('stock-out/search')}}" method="GET">
                        <input type="text" placeholder="Search..." name="q"  value="{{$q}}">
                        {{-- value="{{$q}}" when search give cost search show on it --}}
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
                        <th>Out Date</th>
                        <th>Reference</th>
                        <th>Warehouse</th>
                        <th>Description</th>
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
                    @foreach ($outs as $out)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>
                                <a href="{{ url('stock-out/detail/' . $out->id) }}">{{ $out->out_date }}</a>
                            </td>
                            <td>{{ $out->reference }}</td>
                            <td>{{ $out->wname }}</td>
                            <td>{{ $out->description }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$outs->links()}}
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#sidebar-menu').removeClass('active open');
            $('#sidebar-menu li ul li').removeClass('active');

            $('#menu_stock').addClass('active open');
            $('#stock_collapse').addClass('collapse in');
            $('#menu_out').addClass('active');
        });
    </script>
@endsection
