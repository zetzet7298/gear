<template>
    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Danh Sách Khách Hàng</h2>

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
                    <th>Mã Khách Hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in khachhangs">
                    <td>{{item.id}}</td>
                    <td>{{item.HoTen}}</td>
                    <td>{{item.DiaChi}}</td>
                    <td>{{item.SDT}}</td>
                    <td>{{item.Email}}</td>
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
                khachhangs:[],
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/khachhang/all')
                .then(function (response) {
                    app.khachhangs = response.data;
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