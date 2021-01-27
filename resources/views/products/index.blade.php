    @extends('Layouts.master')
    @section('header')
        <strong>Products</strong>
    @endsection
    @section('content')
        <div class="card card-gray">
            <div class="toolbox">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{route('product.create')}}" class="btn btn-primary btn-sm btn-oval">
                            <i class="fa fa-plus-circle"></i> Create
                        </a>
                        <button class="btn btn-sm btn-oval btn-primary" type="button" data-toggle='modal' data-target='#modalImport'>
                            <i class="fa fa-download"></i> Import
                        </button>

                    </div>
                    <div class="col-sm-6">
                        <form class="search" action="{{url('product/search')}}" method="GET">
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
                            <th>Photo</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Onhand</th>
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
                        @foreach ($products as $p)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <img src="{{$p->photo}}" alt="file" width="45" height="35">
                                </td>
                                <td><a href={{url('product/detail/' . $p->id)}}>{{ $p->code }}</a></td>
                                <td>{{$p->name}}</td>
                                <td>{{$p->brand}}</td>
                                <td>{{$p->cname}}</td>
                                <td>{{$p->onhand}} {{$p->uname}}</td>
                                <td class="action">
                                    <a href="{{route('product.delete',$p->id)}}" class="text-danger" title="Delete" onclick="return confirm('Do you want to delete?') ">
                                        <i class="fa fa-trash"></i>
                                    </a>&nbsp;
                                    <a href="{{route('product.edit',$p->id)}}" class="text-success" title="edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{$products->links()}} --}}
                {{$products->appends(request()->input('q'))->links()}}
                {{-- use append when search paginate not error --}}
            </div>
        </div>
        <!-- Modal to import product -->
    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form action="{{url('product/import')}}" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Import Products</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">

                      <div class="form-group row">
                          <label for="import_file" class="col-sm-3">Name <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                              <input type="file" class="form-control" id="file_import" name='file_import' required>
                              <p>
                              </p>
                              <p>
                                  If you don't have product template,
                                  <a href="{{asset('imports/template.csv')}}">please click here to download.</a>
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <div style='padding: 5px'>
                          <button type='submit' class="btn btn-primary btn-sm  btn-oval">Import</button>
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
            $(document).ready(function(){
                $('#sidebar-menu').removeClass('active open');
                $('#sidebar-menu li ul li').removeClass('active');

                $('#menu_product').addClass('active');
            });
        </script>
    @endsection
