<template>
    <div>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>Danh Sách Khuyến Mãi</h2>

                            </div>
                            <div class="pull-right">

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Thêm Khuyến Mãi</button>

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
                    <th>Mã Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Tên Khuyến Mãi</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Ngày Kết Thúc</th>
                    <th>Phần Trăm Khuyến Mãi</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in khuyenmais">
                    <td>{{item.MaSP}}</td>
                    <td>{{item.TenSP}}</td>
                    <td>{{item.TenKM}}</td>
                    <td>{{item.NgayBD}}</td>
                    <td>{{item.NgayKT}}</td>
                    <td>{{item.PhanTramKM}}</td>
                    <td :id="item.MaSP"><a href="#" data-target='#edit-item' data-toggle='modal' @click="editItem(item)" class="edit-item"><span class="glyphicon glyphicon-edit"></span></a></td>
                    <td><a href="#" @click.prevent="deleteKM(item.MaSP,index)"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
                </tbody>
            </table>
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            <h4 class="modal-title" id="myModalLabel">Thêm Khuyến Mãi</h4>

                        </div>

                        <div class="modal-body">
                            <form class="form-them" data-toggle="validator">

                                <div class = "form-group">
                                    <label class="control-lable" for="loaiSP">Sản phẩm: </label>
                                    <select class="form-control" v-model="khuyenmai.MaSP" id="loaiSP" @change="getSanPham()">
                                        <option value="0" disabled>Chọn loại sản phẩm</option>
                                        <option v-for="item in sanphams" :value="item.MaSP">{{item.TenSP}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="tenKM">Tên Khuyến Mãi:</label>

                                    <input type="text" id="tenKM" v-model="khuyenmai.TenKM" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="ngayBatDau">Ngày Bắt Đầu:</label>

                                    <input type="date" id="ngayBatDau" v-model="khuyenmai.NgayBD" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="ngayKetThuc">Ngày Kết Thúc:</label>

                                    <input type="date" id="ngayKetThuc" v-model="khuyenmai.NgayKT" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="phanTramKM">Phần Trăm Khuyến Mãi:</label>

                                    <input type="number" id="phanTramKM" v-model="khuyenmai.PhanTramKM" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <button type="submit" @click.prevent="saveForm" class="btn crud-submit btn-success">Thêm</button>

                                </div>

                            </form>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                            <h4 class="modal-title" id="myModalLabel">Cập Nhật Khuyến Mãi</h4>

                        </div>

                        <div class="modal-body">
                            <form class="form-sua" data-toggle="validator">
                                <input type="hidden" id="id" v-model="khuyenmai.MaSP">
                                <div class = "form-group">
                                    <label class="control-lable" for="loaiSP">Sản phẩm: </label>
                                    <select class="form-control" v-model="khuyenmai.MaSP" id="loaiSP" @change="getSanPham()">
                                        <option value="0" disabled>Chọn loại sản phẩm</option>
                                        <option v-for="item in sanphams" :value="item.MaSP">{{item.TenSP}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="tenKM">Tên Khuyến Mãi:</label>

                                    <input type="text" id="tenKM" v-model="khuyenmai.TenKM" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="ngayBatDau">Ngày Bắt Đầu:</label>

                                    <input type="date" id="ngayBatDau" v-model="khuyenmai.NgayBD" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="ngayKetThuc">Ngày Kết Thúc:</label>

                                    <input type="date" id="ngayKetThuc" v-model="khuyenmai.NgayKT" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="phanTramKM">Phần Trăm Khuyến Mãi:</label>

                                    <input type="number" id="phanTramKM" v-model="khuyenmai.PhanTramKM" class="form-control"  />

                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <button type="submit" @click.prevent="editForm" class="btn crud-submit btn-success">Sửa</button>

                                </div>

                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div></div>
</template>
<script>
    export default {
        data:function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                khuyenmais:[],
                khuyenmai: new Form({
                    // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    MaSP:'',
                    TenKM:'',
                    NgayBD:'',
                    NgayKT:'',
                    PhanTramKM:''
                }),
                sanphams:[],
                id:''
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/khuyenmai/all')
                .then(function (response) {
                    app.khuyenmais = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load khuyenmais")
                });
        },
        methods:{
            getSanPham(){
                var app = this;
                axios.get('/admin/product/all')
                    .then(function (response) {
                        app.sanphams = response.data;
                    }.bind(this))
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not load products")
                    });
            },
            saveForm(){
                //var app = this;
                //var newProduct = app.product;
                this.khuyenmai.post('/admin/khuyenmai')
                    .then((response)=>{
                        alert(response.data);
                        this.reload();
                    })
                    .catch(()=>{
                        console.log("Error.....")
                    })
            },
            reload(){
                var app = this;
                axios.get('/admin/khuyenmai/all')
                    .then(function (response) {
                        app.khuyenmais = response.data;
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not load khuyenmais")
                    });
            },
            deleteKM(id,index){
                if(confirm('Bạn có thật sự muốn xoá?')){
                    var app = this;
                    axios.delete('/admin/khuyenmai/'+id)
                        .then(function(response){
                            app.khuyenmais.splice(index,1);
                            alert('Đã xoá');
                        })
                        .catch(function(response){
                            alert('Đã xoá!');
                        })
                }
            },
            editItem(item){
                this.khuyenmai.clear();
                this.khuyenmai.reset();
                this.khuyenmai.fill(item);
            },
            editForm(){
                //var app = this;
                //var newProduct = app.product;
                var id = this.khuyenmai.MaSP;
                this.khuyenmai.put('/admin/khuyenmai/'+id)
                    .then((response)=>{
                        alert(response.data);
                        this.reload();
                    })
                    .catch(()=>{
                        console.log("Error.....")
                    })
            },
        },
        created() {
            this.getSanPham();
        }
    }
</script>