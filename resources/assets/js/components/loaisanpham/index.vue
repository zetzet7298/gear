<template>
    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Danh Sách Loại Sản Phẩm</h2>

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
                    <th>Mã Loại SP</th>
                    <th>Tên Loại SP</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in loaisanphams">
                    <td>{{item.MaLoaiSP}}</td>
                    <td>{{item.TenLoaiSP}}</td>
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
                loaisanphams:[],
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/loaisp/all')
                .then(function (response) {
                    app.loaisanphams = response.data;
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