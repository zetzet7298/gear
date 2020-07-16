<template>
    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Danh Sách Thương Hiệu</h2>

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
                    <th>Mã Thương Hiệu</th>
                    <th>Tên Thương Hiệu</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in thuonghieus">
                    <td>{{item.MaThuongHieu}}</td>
                    <td>{{item.TenThuongHieu}}</td>
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
                thuonghieus:[],
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/thuonghieu/all')
                .then(function (response) {
                    app.thuonghieus = response.data;
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