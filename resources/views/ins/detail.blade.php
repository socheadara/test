@extends('Layouts.master')
@section('header')
    <strong> Stock In Detail</strong>
@endsection
@section('content')
<form>
    @csrf
    <input type="hidden" id="id" value="{{ $in->id }}">
    <div class="card card-gray">
        <div class="toolbox">
            <a href="{{url('stock-in')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
            <a href="{{route('stock-in.create')}}" class="btn btn-primary btn-sm btn-oval">
                <i class="fa fa-plus-circle"></i> Create
            </a>
            <a href="{{route('stock-in.delete',$in->id)}}" class="btn btn-danger btn-sm btn-oval" onclick="return confirm('Do you want to delete?')">
                <i class="fa fa-trash"></i> Delete
            </a>
            <a href="{{ route('stock-in.print',$in->id) }}" class="btn btn-sm btn-primary btn-oval" target="_blank">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="in_date"  class="col-sm-5">  In Date :</label>
                        <div class="col-sm-7">
                            <span class="" id="lb_in_date">{{ $in->in_date }}</span>
                            <input type="date" class="form-control hide" id="in_date" value="{{ $in->in_date }}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="warehouse"  class="col-sm-5"> Warehouse :</label>
                        <div class="col-sm-7">
                            <span id="lb_warehouse">{{ $in->wname }}</span>
                            <select id="warehouse" class="form-control hide">
                                <option value="">----Select----</option>
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ $w->id==$in->warehouse_id?'selected':'' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="po_no"  class="col-sm-5">  PO No. :</label>
                        <div class="col-sm-7">
                            <span id="lb_po_no">{{ $in->po_no }}</span>
                            <input type="text" class="form-control hide" id="po_no" value="{{ $in->po_no }}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="reference"  class="col-sm-5">  Reference :</label>
                        <div class="col-sm-7">
                            <span id="lb_reference">{{ $in->reference }}</span>
                            <input type="text" class="form-control hide" id="reference" value="{{ $in->po_no }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="description"  class="col-sm-5">  Description :</label>
                        <div class="col-sm-7">
                            <span id="lb_description">{{ $in->description }}</span>
                            <input type="text" class="form-control hide" id="description" value="{{ $in->description }}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-sm btn-oval btn-primary" type="button" id="btnEdit" onclick="editMaster()">
                            <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-oval btn-success hide" type="button" id="btnSave" onclick="saveMaster()">
                        <i class="fa fa-save"></i> Save
                    </button>
                    <button class="btn btn-sm btn-oval btn-danger hide" type="button" id="btnCancel" onclick="cancelMaster()">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <h5>Items</h5>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-sm btn-primary btn-oval" type="button"
                        data-target="#addItem" data-toggle="modal"><i class="fa fa-plus"></i> Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p></p>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            @php($i=1)
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->pcode }}</td>
                                    <td>{{ $item->pname }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->uname }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger btn-oval" onclick="removeItem(event,this,{{ $item->id }})">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal for add option -->
<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="addItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('stock-in/item/save_new')}}" method="POST" >
            @csrf
            <input type="hidden" name="id" value="{{ $in->id }}">
            <input type="hidden" name="warehouse_id" value="{{ $in->warehouse_id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        {{-- this product read from detail function --}}
                        <label for="item" class="col-sm-3">Product <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="item" id="item" class="form-control chosen-select" required>
                                <option value="">---- Select ----</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="qty1" class="col-sm-3">Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" step="1" value="1" min="0" id="qty1" class="form-control" name="quantity">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style='padding: 5px'>
                        <button class="btn btn-primary btn-sm  btn-oval">Save </button>
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
    <script>
        // function to removeItem
        function removeItem(evt, obj, id)
        {
            evt.preventDefault();
            let con = confirm('Do you want to delete!');
            if(con)
            {
                $.ajax({
                    type: "GET",
                    url: url + "/stock-in/item/delete/" + id,
                    success: function(sms)
                    {
                        if(sms)
                        {
                            $(obj).parent().parent().remove();
                        }
                    }
                });
            }

        }
        //function edit on datail
        function editMaster()
        {
            $("#lb_in_date, #btnEdit, #btnCancel ,#lb_warehouse, #lb_po_no, #lb_reference, #lb_description").addClass('hide');//when click button edit on view detail that add class hide on button edit
            $("#in_date, #btnSave , #btnCancel ,#warehouse, #po_no, #reference, #description").removeClass('hide');//when click button edit that remove class hide on button save and cancel
        }
        function cancelMaster()
        {
            $("#lb_in_date, #btnEdit, #btnCancel ,#lb_warehouse, #lb_po_no, #lb_reference, #lb_description").removeClass('hide');//when click button cancel on view detail that remove class hide on button edit
            $("#in_date, #btnSave, #btnCancel, #warehouse, #po_no, #reference, #description").addClass('hide');//when click button cancel that add class hide on button save and cancel
        }
        function saveMaster()
        {
            // use route post have token
            let token = $("input[name='_token']").val();
            let data = {
                id: $("#id").val(),
                in_date: $("#in_date").val(),
                warehouse_id: $("#warehouse").val(),
                po_no: $("#po_no").val(),
                reference: $("#reference").val(),
                description: $("#description").val()
            };
            let con = confirm("Do to you save!");
            if(con)
            {
                $.ajax({
                    type: "POST",
                    url: url + "/stock-in/master/save_master",
                    data: data,
                    beforeSend: function(request)
                    {
                        return request.setRequestHeader('X-CSRF-Token',token);
                    },
                    success: function(sms)
                    {
                        if(sms>0)
                        {
                            location.href = url + "/stock-in/detail/" + sms;
                        }
                        else
                        {
                            alert('Fail to save stock, please check again!');
                        }
                    }
                });
            }
        };
    </script>
@endsection
