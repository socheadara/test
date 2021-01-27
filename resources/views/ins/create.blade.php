@extends('Layouts.master')
@section('header')
    <strong>Create Stock In</strong>
@endsection
@section('content')
<form>
    <div class="card card-gray">
        <div class="toolbox">
            <button class="btn btn-sm btn-primary btn-oval" onclick="save()">
                <i class="fa fa-save"></i> Save
            </button>
            <a href="{{url('stock-in')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
        </div>
        <div class="card-block">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="in_date"  class="col-sm-5">  In Date <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <input type="date"  class="form-control" id="in_date" name="in_date" required autofocus value="{{old('in_date')}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="warehouse"  class="col-sm-5"> Warehouse <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <select name="warehouse" id="warehouse" class="form-control">
                                <option value=""></option>
                                @foreach ($ws as $w)
                                    <option value="{{$w->id}}">{{$w->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="po_no"  class="col-sm-5">  PO No.</label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="po_no" name="po_no" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="reference"  class="col-sm-5">  Reference </label>
                        <div class="col-sm-7">
                            <input type="text"  class="form-control" id="reference" name="reference">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="description"  class="col-sm-5">  Description </label>
                        <div class="col-sm-7">
                            <textarea name="description" id="description" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h4>Items</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <input type="text"  class="form-control" id="barcode" name="barcode">
                </div>
                <div class="col-sm-5">
                    <select name="product" id="product" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach ($products as $p)
                            <option value="{{$p->id}}" pcode="{{ $p->code }}" pname="{{ $p->name }}" uname="{{ $p->uname }}">{{ $p->code }}  .  {{$p->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="qty" name="qty" class="form-control" onkeypress="pressEnter(event)">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-sm btn-primary btn-oval" type="button" onclick="addItem()">Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p></p>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal for edit option -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('product/import')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="item" class="col-sm-3">Product <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="item" id="item" class="form-control chosen-select">
                                <option value="">---- Select ----</option>
                                @foreach ($products as $p)
                                    <option value="{{$p->id}}" pcode="{{ $p->code }}" pname="{{ $p->name }}" uname="{{ $p->uname }}">{{ $p->code }}  .  {{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="qty1" class="col-sm-3">Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.1" value="1" min="0" id="qty1" class="form-control" name="qty1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style='padding: 5px'>
                        <button type='button' id="btn" onclick="saveEdit()" class="btn btn-primary btn-sm  btn-oval">Save </button>
                        <button type="button" class="btn btn-danger btn-sm btn-oval" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
    <script>
        var url = "{{ url('/') }}";
    </script>
    <script src="{{asset('js/stock-in.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#sidebar-menu').removeClass('active open');
            $('#sidebar-menu li ul li').removeClass('active');

            $('#menu_stock').addClass('active open');
            $('#stock_collapse').addClass('collapse in');
            $('#menu_in').addClass('active');
        });
    </script>
@endsection
