@extends('Layouts.master')
@section('header')
    <strong>Edit Products</strong>
@endsection
@section('content')
<form action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
    @method('PATCH')
    <div class="card card-gray">
        <div class="toolbox">
            <button class="btn btn-sm btn-primary btn-oval">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="{{url('product')}}" class="btn btn-warning btn-sm btn-oval">
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
                <div class="col-sm-6">

                    <div class="form-group row">
                        <label for="code"  class="col-sm-5">  Code <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="code" name="code" required autofocus value="{{$product->code}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name"  class="col-sm-5"> Name <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="name" name="name" required  value="{{$product->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="barcode"  class="col-sm-5">  Barcode </label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="barcode" name="barcode"   value="{{$product->barcode}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand"  class="col-sm-5"> Brand</label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="brand" name="brand"  value="{{$product->brand}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id"  class="col-sm-5"> Category <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select name="category_id" id="category_id" class="form-control">
                                <option value=""></option>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->id}}" {{$cat->id==$product->category_id?'selected':''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_id"  class="col-sm-5"> Unit <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select name="unit_id" id="unit_id" class="form-control">
                                <option value=""></option>
                                @foreach ($units as $unit)
                                    <option value="{{$unit->id}}" {{$unit->id==$product->unit_id?'selected':''}}>{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price"  class="col-sm-5"> Price($)</label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="price" name="price"  value="{{$product->price}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cost"  class="col-sm-5"> Cost($)</label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="cost" name="cost"  value="{{$product->cost}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="description"  class="col-sm-5"> Description</label>
                        <div class="col-sm-7">
                            <textarea name="description" id="description" class="form-control" cols="30" rows="1">{{$product->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="photo"  class="col-sm-5"> Photo</label>
                        <div class="col-sm-7">
                            <input type="file"  class="form-control"  id="photo" name="photo" onchange="preview(event)">
                            <div style="margin-top: 9px">
                                <img src="{{asset($product->photo)}}" alt="photo" id="img" width="150">
                            </div>
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
