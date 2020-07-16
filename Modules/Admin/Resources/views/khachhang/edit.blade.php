<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
  
      <div class="modal-content">
  
        <div class="modal-header">
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
  
          <h4 class="modal-title" id="myModalLabel">Cập Nhật Khách Hàng</h4>
  
        </div>
  
        <div class="modal-body">
            <div class="alert alert-success" id="suathanhcong">

              </div>
              @if(count($errors) >0)
              <div class="alert alert-danger">
                  @foreach($errors->all() as $err)
                  {{$err}}
                  @endforeach
              </div>
              @endif
                <form class="form-edit" data-toggle="validator" action="admin/thuonghieu/edit" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label" for="title">Tên Khách Hàng:</label>
    
                        <input type="text" id="tenKhachHang" name="tenKhachHang" class="form-control" data-error="Please enter title." required />
                        
                        <div class="help-block with-errors"></div>
    
                    </div>
  
  
                  <div class="form-group">
  
                      <button type="submit" class="btn crud-edit btn-success">Cập Nhật</button>
  
                  </div>
  
                </form>
  
        </div>
  
      </div>
  
    </div>
  
  </div>
