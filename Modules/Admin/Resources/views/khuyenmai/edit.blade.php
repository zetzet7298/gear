<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
  
      <div class="modal-content">
  
        <div class="modal-header">
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
  
          <h4 class="modal-title" id="myModalLabel">Cập Nhật Khuyến Mãi</h4>
  
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
                <div class="form-group" id="showGia">
                    <label class="control-label" for="title">Giá:</label>

                    <input readonly type="text" id="gia" name="gia" class="form-control gia" data-error="Please enter title." />
                    
                    <div class="help-block with-errors"></div>

                </div>
                  <div class="form-group">
                    <label class="control-label" for="title">Tên Khuyến Mãi:</label>

                    <input type="text" id="tenKhuyenMai" name="tenKhuyenMai" class="form-control" data-error="Please enter title."  />
                    
                    <div class="help-block with-errors"></div>

                </div>
                <div class="form-group">
                  <label class="control-label" for="title">Phần Trăm KM:</label>

                  <input  type="number" id="phanTramKM" name="phanTramKM" class="form-control phanTramKM" data-error="Please enter title."  />
                  
                  <div class="help-block with-errors"></div>

              </div>
              <div class="form-group" id="showGia">
                  <label class="control-label" for="title">Giá Khuyến Mãi:</label>

                  <input readonly type="text" id="giaKM" name="giaKM" class="form-control giaKM" data-error="Please enter title." />
                  
                  <div class="help-block with-errors"></div>

              </div>
              <div class="form-group">
                <label class="control-label" for="title">Ngày Bắt Đầu:</label>

                <input type="date" id="ngayBatDau" name="ngayBatDau" class="form-control" data-error="Please enter title."  />
                
                <div class="help-block with-errors"></div>

            </div>
            <div class="form-group">
              <label class="control-label" for="title">Ngày Kết Thúc:</label>

              <input type="date" id="ngayKetThuc" name="ngayKetThuc" class="form-control" data-error="Please enter title."  />
              
              <div class="help-block with-errors"></div>

          </div>
          <div class="form-group">
            <label class="control-label" for="title">Ghi Chú:</label>

            <input type="text" id="ghiChu" name="ghiChu" class="form-control" data-error="Please enter title."  />
            
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
