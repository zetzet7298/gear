<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="row">

                <div class="col-lg-12 margin-tb">

                    <div class="pull-left">

                        <h2>Báo Cáo Doanh Thu</h2>

                    </div>

                    <div class="pull-right">

                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Post</button>

                    </div>

                </div>

            </div>
            <div class="col-md-4">
                <form action="" method="POST">
                    <?php

                            $month = date('m');
                            $day = date('d');
                            $year = date('Y');

                            $today = $year . '-' . $month . '-' . $day;
                            ?>
                    <div class="form-group">
                        <label class="control-label" for="title">Từ Ngày:</label>

                        <input type="date" value="<?php echo $today;?>" id="tuNgay" name="tuNgay" class="form-control" data-error="Please enter title." required />

                        <div class="help-block with-errors"></div>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">Đến Ngày:</label>

                        <input type="date" value="<?php echo $today;?>" id="denNgay" name="denNgay" class="form-control" data-error="Please enter title." required />

                        <div class="help-block with-errors"></div>

                    </div>
                    <input type="submit" class="btn btn-success" value="Lọc"/>
                </form>
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>Ngày Thanh Toán</th>
                    <th>Tổng Tiền Đơn Hàng</th>
                    <th>Tổng Giảm Giá Hàng</th>
                    <th>Tổng Giảm Giá Cho Khách</th>
                    <th>Tổng Tiền Trả Hàng</th>
                    <th>Doanh Thu Thực</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<script>
    export default {
        data:function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                doanhthus:[],
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/baocao/all')
                .then(function (response) {
                    app.doanhthus = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load products")
                });
        },
        methods:{
            viewHoaDon:function (MaHD) {

            }
        },
    }
</script>