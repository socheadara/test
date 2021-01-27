@extends('Layouts.master')
@section('header')
    <strong>Detail Products</strong>
@endsection
@section('content')
<form action="#" >
    <div class="card card-gray">
        <div class="toolbox">
            <a href="{{url('product')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
            <a href="{{route('product.create')}}" class="btn btn-primary btn-sm btn-oval">
                <i class="fa fa-plus-circle"></i> Create
            </a>
            <a href="{{route('product.edit',$p->id)}}" class="btn btn-success btn-sm btn-oval">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{route('product.delete',$p->id)}}" class="btn btn-danger btn-sm btn-oval" onclick="return confirm('Do you want to delete?')">
                <i class="fa fa-trash"></i> Delete
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
            <div class="row">
                <div class="col-sm-6">

                    <div class="form-group row">
                        <label for="code"  class="col-sm-5">  Code </label>
                        <div class="col-sm-7">
                            : {{ $p->code }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name"  class="col-sm-5"> Name </label>
                        <div class="col-sm-7">
                            : {{ $p->name }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="barcode"  class="col-sm-5">  Barcode </label>
                        <div class="col-sm-7">
                            : {{ $p->barcode }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand"  class="col-sm-5"> Brand</label>
                        <div class="col-sm-7">
                            : {{ $p->brand }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id"  class="col-sm-5"> Category </label>
                        <div class="col-sm-7">
                            : {{ $p->cname}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_id"  class="col-sm-5"> Unit </label>
                        <div class="col-sm-7">
                            : {{ $p->uname }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price"  class="col-sm-5"> Price($)</label>
                        <div class="col-sm-7">
                            : {{ $p->price }} $
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cost"  class="col-sm-5"> Cost($)</label>
                        <div class="col-sm-7">
                            : {{ $p->cost }} $
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-5"> Onhand</label>
                        <div class="col-sm-7">
                            : {{ $p->onhand }} {{ $p->uname }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="description"  class="col-sm-5"> Description</label>
                        <div class="col-sm-7">
                            : {{ $p->description }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="photo"  class="col-sm-5"> Photo</label>
                        <div class="col-sm-7">
                            <img src="{{ asset($p->photo) }}" alt="photo" id="img" width="150">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="photo"  class="col-sm-5"> </label>
                        <div class="col-sm-7">
                            <img src="{{ asset($p->qrcode) }}" alt="Qrcode" id="img" width="100">
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

            $('#menu_product').addClass('active');
        });
        function preview(evt)
        {
            var img = document.getElementById('img');
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    </script>
@endsection
