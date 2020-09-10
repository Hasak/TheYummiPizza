$(document).ready(function (){
    var link=window.location;
    if(link.pathname!=="/" && link.pathname!==""){;
        $(".for-active[href='"+link.href+"']").addClass("active");
    }
    else{
        $("#logo").css('color','white');
    }
    if(link.pathname==="/order")
        refreshCart();
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(".quantity").change(function (){
    var t=$(this);
    var id=t.attr('data-id');
    var r=$(".item-row[data-id='"+id+"']");
    var b=r.find('.to-cart');
    var pricecell=r.children('.price');
    var price=pricecell.attr('data-price');
    var totalcell=r.children('.total');
    var total=price*t.val();
    if(total){
        totalcell.html($.number(total,2,',','.')+" &euro;");
        b.prop('disabled',false);
    }
    else{
        totalcell.html("");
        b.prop('disabled',true);
    }
    //alert(price);
});
$(".to-cart").click(function (){
    var t=$(this);
    var id=t.attr('data-id');
    var q=$(".quantity[data-id='"+id+"']");
    var insertto=$("#cartcard");
    t.prop("disabled",true);
    q.prop("disabled",true);
    insertto.html("<p class='text-muted c'><span class='fas fa-fw fa-arrow-up'></span> Adding to Cart...</p>");
    $.ajax({
        url: "/addtocart",
        type: "post",
        data: {id:id,q:q.val()},
        success: function () {
            refreshCart();
            t.prop("disabled",false);
            q.prop("disabled",false);
        },
        error: function (xhr, data) {
            $("#erroralert").slideDown('fast');
        }
    });
});
function deleteitem(t,id){
    var r=t.parent();
    t.prop("disabled",true)
    r.html("<td class='c' colspan='3'>Deleting...</td>");
    $.ajax({
        url: "/deleteitem",
        type: "post",
        data: {id:id},
        success: function () {
            refreshCart();
        },
        error: function () {
            r.html("<td colspan='3'>Error</td>");
            $("#erroralert").slideDown('fast');
        }
    });
}
function deleteorder(id){
    var insertto=$("#cartcard");
    insertto.html("<p class='text-muted c'><span class='fas fa-fw fa-times'></span> Emptying Cart...</p>");
    $.ajax({
        url: "/deleteorder",
        type: "post",
        data: {id:id},
        success: function () {
            refreshCart();
        },
        error: function () {
            insertto.html("<p class='text-muted c'><span class='fas fa-fw fa-times'></span> Error</p>");
            $("#erroralert").slideDown('fast');
        }
    });
}
function refreshCart(){
    var insertto=$("#cartcard");
    $.ajax({
        url: "/cartcard",
        type: "post",
        data: {},
        success: function (data) {
            insertto.html(data);
        },
        error: function (xhr, data) {
            insertto.html("Error: "+data);
        }
    });
}
$("#addr").keyup(function (e){
    if(e.keyCode==13){//Enter
        $("#confirmer").click();
        return;
    }
    const price_per_letter=0.05;
    var t=$(this);
    var sumcell=$("#sumprice");
    var shipcell=$("#shipprice");
    var totalcell=$("#totalpricecalculated");
    var sum_raw=parseFloat(sumcell.attr("data-sum"));
    var total_ship_raw=price_per_letter*t.val().length;
    var total_ship=$.number(total_ship_raw,2,',','.');
    var total_raw=total_ship_raw+sum_raw;
    var total=$.number(total_raw,2,',','.');
    shipcell.html(total_ship);
    totalcell.html(total);
});
$("#confirmer").click(function (){
    var t=$(this);
    var addrinput=$("#addr");
    var all=$("#allpage");
    var id=$("#order_id").val();
    var addr=addrinput.val();
    var on_error="<div class='alert alert-danger'>Order no. <span class='font-weight-bold'>"+id+"</span> has error.</div>";
    t.html("<span class='fas fa-fw fa-sync-alt fa-spin'></span> Confirming...");
    t.prop("disabled",true);
    addrinput.prop("disabled",true);
    if(addr.length){
        $.ajax({
            url: "/confirmorder",
            type: "post",
            data: {id:id,addr:addr},
            success: function (data) {
                all.html("<div class='alert alert-success'>Order no. <span class='font-weight-bold'>"+id+"</span> successfully ordered. We will be soon there.</div>");
            },
            error: function (xhr, data) {
                all.html(on_error);
            }
        });
    }
    else{

    }
});
