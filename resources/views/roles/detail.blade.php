@extends('Layouts.master')
@section('header')
    <strong>Roles</strong>
@endsection
@section('content')
    {{csrf_field()}}
    <div class="card card-gray">
        <div class="toolbox">
            <a href="{{url('role ')}}" class="btn btn-warning btn-sm btn-oval">
                <i class="fa fa-reply"></i> Back
            </a>
        </div>
        <div class="card-block">
            <p>
                <strong class="text-primary">
                    Set permission for role [{{$role->name}}]
                </strong>
            </p>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>View</th>
                        <th>Create</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                        @foreach ($permissions as $p)
                            <tr rid="{{$role->id}}" rpid="{{$p->id?$p->id:'0'}}" pid="{{$p->pid}}">
                                <td>{{$i++}}</td>
                                <td>{{$p->alias}}</td>
                                <td>
                                    <input type="checkbox" value="{{$p->list?'1':'0'}}" {{$p->list?'checked':''}}
                                                onchange="save(this)">
                                </td>
                                <td>
                                    <input type="checkbox" value="{{$p->create?'1':'0'}}" {{$p->create?'checked':''}}
                                                onchange="save(this)">
                                </td>
                                <td>
                                    <input type="checkbox" value="{{$p->edit?'1':'0'}}" {{$p->edit?'checked':''}}
                                                onchange="save(this)">
                                </td>
                                <td>
                                    <input type="checkbox" value="{{$p->delete?'1':'0'}}" {{$p->delete?'checked':''}}
                                                onchange="save(this)">
                                </td>
                            </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var best_url = "{{url('/')}}";
        $(document).ready(function(){
            $('#sidebar-menu').removeClass('active open');
            $('#sidebar-menu li ul li').removeClass('active');

            $('#menu_security').addClass('active open');
            $('#security_collapse').addClass('collapse in');
            $('#menu_role').addClass('active');
        });
        function save(obj)
        {
            let token = $("input[name = '_token']").val();
            let val = $(obj).val();
            if(val == 1)
            {
                $(obj).val(0);
                {{--  val(value)  --}}
            }
            else
            {
                $(obj).val(1);
            }

            let tr = $(obj).parent().parent();
            let rid = $(tr).attr('rid');
            let rpid = $(tr).attr('rpid');
            let pid = $(tr).attr('pid');
            let tds = $(tr).find('td');
            let list = $(tds[2]).children('input').val();
            let create = $(tds[3]).children('input').val();
            let edit = $(tds[4]).children('input').val();
            let del = $(tds[5]).children('input').val();
            {{--  bring data to database  --}}
            let data = {
                pid : pid,
                role_id : rid,
                rpid : rpid,
                list : list,
                create : create,
                edit : edit,
                del : del
            };
            {{-- use ajax in jquery --}}
            $.ajax({
                type: 'POST',
                url: best_url + "/role/permission/save",
                data: data,
                beforeSend: function(request){
                    return request.setRequestHeader('X-CSRF-Token',token);
                },
                success: function(sms){
                    $(tr).attr('rpid',sms);
                }
            });
        }
    </script>

@endsection
