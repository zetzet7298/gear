<template>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="row">

                    <div class="col-lg-12 margin-tb">

                        <div class="pull-left">

                            <h2>Chi Tiết Hóa Đơn</h2>

                        </div>

                    </div>

                </div>
                <!-- /.col-lg-12 -->

                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>Tên Sản Phẩm</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in cthoadons">
                        <td>{{item.TenSP}}</td>
                        <td><img :src="'admin_asset/upload/'+item.Thumbnail" alt="" style="width:170;height:100"></td>
                        <td>{{item.Gia}}</td>
                        <td>{{item.SoLuong}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">

                    <div class="col-lg-12 margin-tb">

                        <div class="pull-left">

                            <h2>Thông Tin Người Mua</h2>

                        </div>

                    </div>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr align="center">
                            <th>Tên Khách Hàng</th>
                            <th>Địa Chỉ</th>
                            <th>SĐT</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{khachhang.HoTen}}</td>
                            <td>{{khachhang.DiaChi}}</td>
                            <td>{{khachhang.SDT}}</td>
                            <td>{{khachhang.Email}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

</template>
<script>
    export default {
        data:function () {
            return{
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                cthoadons:[],
                khachhang:{}
            }
        },
        mounted() {
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);
            var app = this;
            axios.get('/admin/thanhtoan/'+id)
                .then(function (response) {
                    app.cthoadons = response.data;
                })
                .catch(function (response) {
                });
            axios.get('/admin/thanhtoan/user/'+id)
                .then(function (response) {
                    app.khachhang = response.data;
                })
                .catch(function (response) {
                });
        }
    }
</script>