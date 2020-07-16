@extends('admin/layout/index');
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
                <div class="row">

                        <div class="col-lg-12 margin-tb">					
            
                            <div class="pull-left">
            
                                <h2>Danh Sách Thương Hiệu</h2>
            
                            </div>
            
                            <div class="pull-right">
            
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Post</button>
            
                            </div>
            
                        </div>
            
                    </div>
            <!-- /.col-lg-12 -->
            <div class="alert alert-success" id="xoathanhcong">

            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tên Thương Hiệu</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            @include('admin/thuonghieu/them')
            @include('admin/thuonghieu/edit')
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script>
$(document).ready(function(){
    $('#themthanhcong').hide();
    $('#suathanhcong').hide();
    $('#xoathanhcong').hide();
    $('.form-them').validate({
        rules:{
            tenThuongHieu:{
                required: true,
                minlength:3,
                maxlength:50,
                alphanumeric:true
            }
        },
        messages:{
            tenThuongHieu:{
                required:'Vui lòng nhập tên thương hiệu!',
                minlength:'Thương hiệu phải có độ dài trong khoảng 3 đến 50 ký tự!',
                maxlength:'Thương hiệu phải có độ dài trong khoảng 3 đến 50 ký tự!',
                alphanumeric:'Không được phép nhập ký tự đặc biệt!'
            }
        }
    });
    $('.form-edit').validate({
        rules:{
            tenThuongHieu:{
                required: true,
                minlength:3,
                maxlength:50,
                alphanumeric:true
            }
        },
        messages:{
            tenThuongHieu:{
                required:'Vui lòng nhập tên thương hiệu!',
                minlength:'Thương hiệu phải có độ dài trong khoảng 3 đến 50 ký tự!',
                maxlength:'Thương hiệu phải có độ dài trong khoảng 3 đến 50 ký tự!',
                alphanumeric:'Không được phép nhập ký tự đặc biệt!'
            }
        }
    });
var url = 'http://localhost/GamingGearTMDT/public/admin/thuonghieu';
function manageRow(data){
    var row = '';
    $.each(data,function(index){
        row += "<tr>";
        row += "<td>"+data[index].MaThuongHieu+"</td>";
        row += "<td>"+data[index].TenThuongHieu+"</td>";
        row += "<td id='"+data[index].MaThuongHieu+"'><button data-toggle='modal' data-target='#edit-item' class='btn btn-primary edit-item'>Edit</button></td>";
        row += "<td id='"+data[index].MaThuongHieu+"'><button class='btn btn-danger delete-item'>Delete</button></td>";
        row += "</tr>";
    });
    $('tbody').html(row);
    $('#dataTables-example').DataTable();
}
$.ajax({
   url:url,
   dataType:'json',
   type:'get',
   cache:false,
   success:function(data){
        manageRow(data);
   } 
}); 
function hienthi(){
    $.ajax({
   url:url,
   dataType:'json',
   type:'get',
   cache:false,
   success:function(data){
        manageRow(data);
   } 
});
}
$('.crud-submit').on('click',function(e){
    e.preventDefault();
    var form_action = $('#create-item').find('form').attr('action');
    var tenThuongHieu = $('#create-item').find('form').find('input[name=tenThuongHieu]').val();
    if($('#create-item').find('form').valid()){
        $.ajax({
   url:form_action,
   dataType:'json',
   data:{tenThuongHieu:tenThuongHieu},
   type:'post',
   success:function(data){
    $('#themthanhcong').html(data);
    $('#themthanhcong').show();
    hienthi();
   }
});
    }
});
$('body').on('click','.edit-item',function(){
   var id = $(this).parent('td').attr('id');
   var tenThuongHieu = $(this).parent('td').prev().text();
   $("#edit-item").find('form').find('input[name="tenThuongHieu"]').val(tenThuongHieu);
   $('#edit-item').find('form').attr('action',url+'/edit/'+id);
});
$('.crud-edit').on('click',function(e){
    e.preventDefault();
    var form_actions = $('#edit-item').find('form').attr('action');
    var tenThuongHieu = $('#edit-item').find('input[name=tenThuongHieu]').val();
    if($('#edit-item').find('form').valid()){
        $.ajax({
            type:'post',
            url:form_actions,
            dataType:'json',
            cache:false,
            data:{tenThuongHieu:tenThuongHieu},
            success:function(data){
                $('#suathanhcong').html(data);
    $('#suathanhcong').show();
    hienthi();
            }
        });
    }
});
$('body').on('click','.delete-item',function(){
    var id = $(this).parent('td').attr('id');
    var obj =$(this).parents('tr');
    $.ajax({
       type:'get',
       url:url+'/'+'delete/'+id,
       success:function(data){
        $('#xoathanhcong').html(data);
        $('#xoathanhcong').show();
        obj.remove();
       } 
    });
});
});
</script>
@endsection