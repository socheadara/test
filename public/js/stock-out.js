
function addItem()
{
    let pid = $("#product").val();
    let pcode = $("#product :selected").attr('pcode');
    let pname = $("#product :selected").attr('pname');
    let unit = $("#product :selected").attr('uname');
    let qty = $("#qty").val();
    if(pid == "" || pcode == undefined || qty == "")
    {
        alert('Please select product to add!');
    }
    else
    {
        let tr = "<tr pid='" + pid +  "'>";
        tr += "<td>"+ pcode + "</td>";
        tr += "<td>"+ pname + "</td>";
        tr += "<td>"+ qty + "</td>";
        tr += "<td>"+ unit + "</td>";
        tr += "<td><a href='#' onclick='removeItem(this, event)' class='btn btn-sm btn-danger btn-oval'>Delete</a>";
        tr += "&nbsp;<a href='#' onclick='editItem(this)' data-toggle='modal' data-target='#editModal' class='btn btn-sm btn-primary btn-oval'>Edit</a></td>";
        tr += "</tr>";
        // then select variable trs to select all rows
        let trs = $("#data tr");
        if(trs.length>0)
        {
            $("#data tr:last-child").after(tr);
        }
        else
        {
            $("#data").html(tr);
        }
        //when add item already clear text in box qty and product
        $("#qty").val("");
        $("#product").val("");
        $("#product").trigger("chosen:updated");
        // use {trigger("chosen:updated")} for help to product clear text in box
    }
}
function pressEnter(evt)
{
    let code = (evt.keyCode ? evt.keyCode : evt.which);
    if(code==13)
    {
        addItem();
    }
}
function removeItem(obj, evt)
{
    evt.preventDefault();
    //evt.preventDefault() use it when click button don't link
    let con = confirm('You want to delete?');
    if(con)
    {
        $(obj).parent().parent().remove();
        // button <tr><td><a>delete</a></td></tr> parent of a is ban td parent of td ban tr in 1 tr removed all so we use 2 parent to remove
    }
}
function editItem(obj)
{
    $('#data tr').removeAttr('active');
    //remove all old active
    $(obj).parent().parent().attr('active','true');
    //add active to we know editting on any product
    let tr = $(obj).parent().parent();
    let tds = $(tr).children();
    let id = $(tr).attr('pid');
    let qty = $(tds[2]).html();
    //qty at column 2 or index column 2
    $('#qty1').val(qty);
    $("#item").val(id);
    $("#item").trigger("chosen:updated");
}
function saveEdit()
{
    let pid = $("#item").val();
    let pcode = $("#item :selected").attr('pcode');
    let pname = $("#item :selected").attr('pname');
    let unit = $("#item :selected").attr('uname');
    let qty = $("#qty1").val();
    if(pid == "" || pcode == undefined || qty == "")
    {
        alert('Please select product to add!');
    }
    else
    {
        let tr = $("#data tr[active='true']");
        let tds = $(tr).children();
        $(tds[0]).html(pcode);
        $(tds[1]).html(pname);
        $(tds[2]).html(qty);
        $(tds[3]).html(unit);
        $(tr).attr('pid', pid);
        $('#editModal').modal('hide');
    }
}
function save()
{
    let master = {
        out_date: $("#out_date").val(),
        warehouse_id: $("#warehouse").val(),
        description: $("#description").val(),
        reference: $("#reference").val()
    }
    let token = $("input[name='_token']").val();
    let items = [];
    let trs = $("#data tr");
    if($("#out_date").val()=="" || $("warehouse").val()=="" || trs.length<=0)
    {
        alert("Please input data correctly !")
    }
    else
    {
        for(let i=0;i<trs.length;i++)
        {
            let tds = $(trs[i]).children();
            let item = {
                product_id: $(trs[i]).attr('pid'),
                quantity: $(tds[2]).html()
            };
            items.push(item);
        }
        let data = {
            master: master,
            items: items
        };
        $.ajax({
            type: "POST",
            url: url + "/stock-out",
            data: data,
            beforeSend: function(request){
                return request.setRequestHeader('X-CSRF-Token',token);
            },
            success: function(sms)
            {
                location.href = url + "/stock-out/detail/" + sms;
                // sms = id
            }
        });
    }
}
