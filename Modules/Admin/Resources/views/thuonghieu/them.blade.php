<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

        <div class="modal-dialog" role="document">
      
          <div class="modal-content">
      
            <div class="modal-header">
      
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      
              <h4 class="modal-title" id="myModalLabel">Thêm Thương Hiệu</h4>
      
            </div>
      
            <div class="modal-body">
              <div class="alert alert-success" id="themthanhcong">

              </div>
                    <form class="form-them" data-toggle="validator" action="admin/thuonghieu/them" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label class="control-label" for="title">Tên Thương Hiệu:</label>
      
                          <input type="text" id="tenThuongHieu" name="tenThuongHieu" class="form-control" data-error="Please enter title." required />
                          
                          <div class="help-block with-errors"></div>
      
                      </div>
      
      
                      <div class="form-group">
      
                          <button type="submit" class="btn crud-submit btn-success">Thêm</button>
      
                      </div>
      
                    </form>
      
            </div>
      
          </div>
      
        </div>
      
      </div>
