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
                    <td>{{item.PhuongThuc}}</td>
                    <td><a :href="'/admin/thanhtoan/detail/'+item.MaHD" @click="viewHoaDon(item.MaHD)"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td :id="item.MaSP"><a href="#" data-target='#edit-item' data-toggle='modal' @click="editItem(item)" class="edit-item"><span class="glyphicon glyphicon-edit"></span></a></td>
                    <td v-show="false">{{item.ThongTin}}</td>
                    <td v-show="false">{{item.NoiDung}}</td>
                    <td><a href="#" @click.prevent="deleteProduct(item.MaSP,index)"><span class="glyphicon glyphicon-trash"></span></a></td>
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

            }
        },
    }
</script>