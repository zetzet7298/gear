<template>
    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Danh Sách Hoá Đơn</h2>

                            </div>

                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Ngày Thanh Toán</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Tiền</th>
                    <th>Phương Thức</th>
                    <th>Chi Tiết</th>
                    <th>Thao Tác</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in hoadons">
                    <td>{{item.MaHD}}</td>
                    <td>{{item.NgayThanhToan}}</td>
                    <td>{{item.TrangThai}}</td>
                    <td>{{item.TongTien}}</td>
                    <td v-if="item.PhuongThuc==1">Thanh toán khi nhận hàng</td>
                    <td><a :href="'/admin/thanhtoan/detail/'+item.MaHD" @click="viewHoaDon(item.MaHD)"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td v-show="false">{{item.ThongTin}}</td>
                    <td v-show="false">{{item.NoiDung}}</td>
                    <td>
                        <a @click="duyetdon(item.MaHD)" class="btn btn-success" v-if="item.TrangThai == 'Chờ xác nhận'">Duyệt Đơn</a>
                        <a @click="huydon(item.MaHD)" class="btn btn-danger" v-if="item.TrangThai == 'Chờ xác nhận' || item.TrangThai == 'Đang lấy hàng'">Huỷ Đơn</a>
                        <a @click="danglayhang(item.MaHD)" class="btn btn-primary" v-if="item.TrangThai == 'Đã xác nhận'">Đang Lấy Hàng</a>
                        <a @click="dalayhang(item.MaHD)" class="btn btn-default" v-if="item.TrangThai == 'Đang lấy hàng'">Đã Lấy Hàng</a>
                        <a @click="danggiaohang(item.MaHD)" class="btn btn-primary" v-if="item.TrangThai == 'Đã lấy hàng'">Đang Giao Hàng</a>
                        <a @click="dagiaohang(item.MaHD)" class="btn btn-warning" v-if="item.TrangThai == 'Đang giao hàng'">Đã Giao Hàng</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div></div>
</template>
<script>
    export default {
        data:function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                hoadons:[],
                status:[]
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/thanhtoan/all')
                .then(function (response) {
                    app.hoadons = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load products")
                });

        },
        methods:{
            viewHoaDon:function (MaHD) {

            },
            changeThaoTac:function () {
                var element = document.getElementById('status');
                var strUser = element.value;
                alert(strUser);
            },
            duyetdon:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận duyệt đơn này?')){
                    axios.get('/admin/thanhtoan/duyetdon/'+MaHD)
                        .then(function (response) {
                            alert('Đã duyệt!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            huydon:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận huỷ đơn này?')){
                    axios.get('/admin/thanhtoan/huydon/'+MaHD)
                        .then(function (response) {
                            alert('Đã huỷ!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            danglayhang:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận thay đổi trạng thái đơn hàng thành "Đang lấy hàng"?')){
                    axios.get('/admin/thanhtoan/danglayhang/'+MaHD)
                        .then(function (response) {
                            alert('Đã thay đổi trạng thái thành "Đang lấy hàng"!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            dalayhang:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận thay đổi trạng thái đơn hàng thành "Đã lấy hàng"?')){
                    axios.get('/admin/thanhtoan/dalayhang/'+MaHD)
                        .then(function (response) {
                            alert('Đã thay đổi trạng thái thành "Đã lấy hàng"!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            danggiaohang:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận thay đổi trạng thái đơn hàng thành "Đang giao hàng"?')){
                    axios.get('/admin/thanhtoan/danggiaohang/'+MaHD)
                        .then(function (response) {
                            alert('Đã thay đổi trạng thái thành "Đang giao hàng"!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            dagiaohang:function (MaHD) {
                var app = this;
                if(confirm('Xác nhận thay đổi trạng thái đơn hàng thành "Đã giao hàng"?')){
                    axios.get('/admin/thanhtoan/dagiaohang/'+MaHD)
                        .then(function (response) {
                            alert('Đã thay đổi trạng thái thành "Đã giao hàng"!')
                            app.reload();
                        })
                        .catch(function (response) {
                        });
                }
            },
            reload:function(){
                var app = this;
                axios.get('/admin/thanhtoan/all')
                    .then(function (response) {
                        app.hoadons = response.data;
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not load products")
                    });
            }
        },
    }
</script>