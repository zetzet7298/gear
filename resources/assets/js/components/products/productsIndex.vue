<template>
    <div>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="row">

                    <div class="col-lg-12 margin-tb">

                        <div class="pull-left">

                            <h2>Danh Sách Sản Phẩm</h2>

                        </div>

                        <div class="pull-right">

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Sản Phẩm</button>

                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <div class="row">
            <input type="text" placeholder="Nhập từ khoá" v-on:keyup="changeTenSP()" v-model="searchTenSP">
            <select v-model="searchLoaiSP" @change="changeLoaiSP()">
                <option value="0" >Chọn loại sản phẩm</option>
                <option v-for="item in loaisanphams" :value="item.MaLoaiSP">{{item.TenLoaiSP}}</option>
            </select>
            <select v-model="searchThuongHieu" @change="changeThuonghieu()">
                <option value="0" >Chọn thương hiệu</option>
                <option v-for="item in thuonghieus" :value="item.MaThuongHieu">{{item.TenThuongHieu}}</option>
            </select>
<!--            <button class="btn btn-danger" @click="TimKiem">Tìm kiếm</button>-->
        </div>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
        <tr align="center">
            <th>ID</th>
            <th>Tên Sản Phẩm</th>
            <th>Loại Sản Phẩm</th>
            <th>Thương Hiệu</th>
            <th v-show="false">Thumbnail</th>
            <th>Tóm Tắt</th>
            <th>Giá</th>
            <th>Số Lượng Tồn</th>
            <th>Detail</th>
            <th>Edit</th>
            <th v-show="false"></th>
            <th v-show="false"></th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item, index in products">
            <td>{{item.MaSP}}</td>
            <td>{{item.TenSP}}</td>
            <td>{{item.TenLoaiSP}}</td>
            <td>{{item.TenThuongHieu}}</td>
            <td v-show="false">{{item.Thumbnail}}</td>
            <td>{{item.TomTat}}</td>
            <td>{{item.Gia}}</td>
            <td>{{item.SoLuongTon}}</td>
            <td><a :href="'/admin/product/detail/'+item.MaSP" @click="viewProduct(item.MaSP)"><span class="glyphicon glyphicon-eye-open"></span></a></td>
            <td :id="item.MaSP"><a href="#" data-target='#edit-item' data-toggle='modal' @click="editItem(item)" class="edit-item"><span class="glyphicon glyphicon-edit"></span></a></td>
            <td v-show="false">{{item.ThongTin}}</td>
            <td v-show="false">{{item.NoiDung}}</td>
            <td><a href="#" @click.prevent="deleteProduct(item.MaSP,index)"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
        </tbody>
    </table>
        <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                        <h4 class="modal-title" id="myModalLabel">Thêm Sản Phẩm</h4>

                    </div>

                    <div class="modal-body">
                        <form class="form-them" data-toggle="validator">

                            <div class="form-group">
                                <label class="control-label" for="tenSanPham">Tên Sản Phẩm:</label>

                                <input type="text" id="tenSanPham" v-model="product.TenSP" class="form-control"  />

                                <div class="help-block with-errors"></div>

                            </div>
                            <div class = "form-group">
                                <label class="control-lable" for="loaiSP">Loại sản phẩm: </label>
                                <select class="form-control" v-model="product.LoaiSP" id="loaiSP" @change="getLoaiSP()">
                                    <option value="0" disabled>Chọn loại sản phẩm</option>
                                    <option v-for="item in loaisanphams" :value="item.MaLoaiSP">{{item.TenLoaiSP}}</option>
                                </select>
                            </div>
                            <div class = "form-group">
                                <label class="control-lable" for="thuongHieu">Thương hiệu:</label>
                                <select class="form-control" v-model="product.ThuongHieu" id="thuongHieu" @change="getThuongHieu()">
                                    <option value="0" disabled>Chọn thương hiệu</option>
                                    <option v-for="item in thuonghieus" :value="item.MaThuongHieu">{{item.TenThuongHieu}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="tomTat">Tóm tắt:</label>

                                <input type="text" id="tomTat" v-model="product.TomTat" class="form-control"  />

                                <div class="help-block with-errors"></div>

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="gia">Giá:</label>

                                <input type="number" id="gia" v-model="product.Gia" class="form-control"  />

                                <div class="help-block with-errors"></div>

                            </div>

                            <div class="form-group">
                                <label class="control-label" for="thongTin">Thông Tin:</label>

                                <ckeditor :editor="editor" :config="editorConfig" id="thongTin" v-model="product.ThongTin" class="form-control ckeditor" tag-name="textarea"></ckeditor>

                                <div class="help-block with-errors"></div>

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="noiDung">Nội Dung:</label>

                                <ckeditor :editor="editor" :config="editorConfig" id="noiDung" v-model="product.NoiDung" class="form-control ckeditor" tag-name="textarea" ></ckeditor>

                                <div class="help-block with-errors"></div>

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="soLuongTon">Số Lượng Tồn:</label>

                                <input type="number" id="soLuongTon" v-model="product.SoLuongTon" class="form-control"  />

                                <div class="help-block with-errors"></div>

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="thumbnail">Thumbnail:</label>

                                <input :form="product" type="file" @change='uploadPhoto' name="photo" class="form-control" :class="{ 'is-invalid': product.errors.has('photo') }">
                                <has-error :form="product" field="photo"></has-error>


                            </div>
                            <div class="form-group">
                                <img class="profile-user-img img-fluid img-circle" :src="getPhoto()" alt="Product picture">
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

                    <h4 class="modal-title" id="myModalLabel">Cập Nhật Sản Phẩm</h4>

                </div>

                <div class="modal-body">
                    <form class="form-sua" data-toggle="validator">
                        <input type="hidden" id="id" v-model="product.MaSP">
                        <div class="form-group">
                            <label class="control-label" for="tenSanPham">Tên Sản Phẩm:</label>

                            <input type="text" id="tenSanPham" v-model="product.TenSP" class="form-control"  />

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class = "form-group">
                            <label class="control-lable" for="loaiSP">Loại sản phẩm: </label>
                            <select class="form-control" v-model="product.MaLoaiSP" id="loaiSP" @change="getLoaiSP()">
                                <option value="0" disabled>Chọn loại sản phẩm</option>
                                <option v-for="item in loaisanphams" :value="item.MaLoaiSP">{{item.TenLoaiSP}}</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <label class="control-lable" for="thuongHieu">Thương hiệu:</label>
                            <select class="form-control" v-model="product.MaThuongHieu" id="thuongHieu" @change="getThuongHieu()">
                                <option value="0" disabled>Chọn thương hiệu</option>
                                <option v-for="item in thuonghieus" :value="item.MaThuongHieu">{{item.TenThuongHieu}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="tomTat">Tóm tắt:</label>

                            <input type="text" id="tomTat" v-model="product.TomTat" class="form-control"  />

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="gia">Giá:</label>

                            <input type="number" id="gia" v-model="product.Gia" class="form-control"  />

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="thongTin">Thông Tin:</label>

                            <ckeditor :editor="editor" :config="editorConfig" id="thongTin" v-model="product.ThongTin" class="form-control ckeditor" tag-name="textarea"></ckeditor>

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="noiDung">Nội Dung:</label>

                            <ckeditor :editor="editor" :config="editorConfig" id="noiDung" v-model="product.NoiDung" class="form-control ckeditor" tag-name="textarea" ></ckeditor>

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="soLuongTon">Số Lượng Tồn:</label>

                            <input type="number" id="soLuongTon" v-model="product.SoLuongTon" class="form-control"  />

                            <div class="help-block with-errors"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="thumbnail">Thumbnail:</label>

                            <input :form="product" type="file" @change='uploadPhoto' name="photo" class="form-control">



                        </div>
                        <div class="form-group">
                            <img class="profile-user-img img-fluid img-circle" :src="getPhoto()" alt="Product picture">
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
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        data:function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                products:[],
                loaisanphams:[],
                thuonghieus:[],
                product: new Form({
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    TenSP:'',
                    Gia:'',
                    NoiDung:'',
                    ThongTin:'',
                    TomTat:'',
                    SoLuongTon:'',
                    photo:'',
                    MaSP:'',
                    MaLoaiSP:'',
                    MaThuongHieu:'',
                }),
                id:'',
                searchTenSP:'',
                searchLoaiSP:0,
                searchThuongHieu:0,
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    // The configuration of the editor.
                }
            }
        },
        mounted(){
            var app = this;
            axios.get('/admin/product/all')
            .then(function (response) {
                app.products = response.data;
            })
            .catch(function (response) {
            });

        },
        methods:{
            reload(){
                var app = this;
                axios.get('/admin/product/all')
                    .then(function (response) {
                        app.products = response.data;
                    })
                    .catch(function (response) {
                    });
            },
            getLoaiSP(){
                var app = this;
                axios.get('/admin/loaisp/all')
                    .then(function (response) {
                        app.loaisanphams = response.data;
                    }.bind(this))
                    .catch(function (response) {
                        console.log(response);
                    })
            },
            getThuongHieu(){
                var app = this;
                axios.get('/admin/thuonghieu/all')
                    .then(function (response) {
                        app.thuonghieus = response.data;
                    }.bind(this))
                    .catch(function (response) {
                        console.log(response);
                    })
            },
            deleteProduct(id,index){
                if(confirm('Bạn có thật sự muốn xoá?')){
                    var app = this;
                    axios.delete('/admin/product/'+id)
                    .then(function(response){
                        app.products.splice(index,1);
                        alert('Đã xoá');
                    })
                    .catch(function(response){
                        alert('Đã xoá!');
                    })
                }
            },
            viewProduct(id){

            },
            editItem(item){
                this.product.clear();
                this.product.reset();
                this.product.fill(item);
            },
            saveForm(){
                //var app = this;
                //var newProduct = app.product;
                this.product.post('/admin/product')
                    .then((response)=>{
                        alert('Đã thêm');
                        this.reload();
                    })
                    .catch(()=>{
                        console.log("Error.....")
                    })
            },
            editForm(){
                //var app = this;
                //var newProduct = app.product;
                var id = this.product.MaSP;
                this.product.put('/admin/product/'+id)
                    .then((response)=>{
                        alert('Đã sửa');
                        this.reload();
                    })
                    .catch(()=>{
                        console.log("Error.....")
                    })
            },
            uploadPhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                        //console.log('RESULT', reader.result)
                        this.product.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            getPhoto(){

            },
            changeTenSP(){
                var tenSP = this.searchTenSP;
                var loaiSP = this.searchLoaiSP;
                var thuongHieu = this.searchThuongHieu;
                var app = this;
                var url = '';
                if(tenSP && loaiSP && thuongHieu){
                    url = '/admin/product/search?TenSP='+tenSP+'&MaLoaiSP='+loaiSP+'&MaThuongHieu='+thuongHieu;

                }
                if(tenSP && loaiSP === 0 && thuongHieu === 0){
                    url = '/admin/product/search?TenSP='+tenSP;

                }
                if(tenSP && loaiSP && thuongHieu === 0){
                    url += '/admin/product/search?TenSP='+tenSP +'&MaLoaiSP='+loaiSP;

                }
                if(tenSP && loaiSP === 0 && thuongHieu){
                    url += '/admin/product/search?TenSP='+tenSP +'&MaThuongHieu='+thuongHieu;

                }
                if(!tenSP && loaiSP === 0 && thuongHieu ===0 ){
                    url += '/admin/product/all';

                }
                if(!tenSP && loaiSP && thuongHieu ===0 ){
                    url =  '/admin/product/search?MaLoaiSP='+loaiSP;

                }
                if(!tenSP && loaiSP === 0 && thuongHieu){
                    url =  '/admin/product/search?MaThuongHieu='+thuongHieu;
                }
                axios.get(url)
                .then(function (response) {
                    app.products = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                })
            },
            changeLoaiSP:function () {
                var loaiSP = this.searchLoaiSP;
                var thuongHieu = this.searchThuongHieu;
                var tenSP = this.searchTenSP;
                var app = this;
                if(loaiSP && thuongHieu ===0 && !tenSP){
                    var url =  '/admin/product/search?MaLoaiSP='+loaiSP;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(thuongHieu && loaiSP && !tenSP){
                    var url =  '/admin/product/search?MaThuongHieu='+thuongHieu+'&MaLoaiSP='+loaiSP;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(tenSP && loaiSP && thuongHieu){
                    var url = '/admin/product/search?TenSP='+tenSP+'&MaLoaiSP='+loaiSP+'&MaThuongHieu='+thuongHieu;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(tenSP && loaiSP && thuongHieu ===0){
                    var url = '/admin/product/search?TenSP='+tenSP+'&MaLoaiSP='+loaiSP;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(!tenSP && loaiSP === 0 && thuongHieu ===0){
                    url += '/admin/product/all';
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
            },
            changeThuonghieu:function () {
                var thuongHieu = this.searchThuongHieu;
                var loaiSP = this.searchLoaiSP;
                var tenSP = this.searchTenSP;
                var app = this;
                if(thuongHieu && loaiSP === 0 && !tenSP){
                    var url =  '/admin/product/search?MaThuongHieu='+thuongHieu;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(thuongHieu && loaiSP && !tenSP){
                    var url =  '/admin/product/search?MaThuongHieu='+thuongHieu+'&MaLoaiSP='+loaiSP;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(tenSP && loaiSP && thuongHieu){
                    var url = '/admin/product/search?TenSP='+tenSP+'&MaLoaiSP='+loaiSP+'&MaThuongHieu='+thuongHieu;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(tenSP && loaiSP ===0 && thuongHieu){
                    var url = '/admin/product/search?TenSP='+tenSP+'&MaThuongHieu='+thuongHieu;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
                if(!tenSP && loaiSP === 0 && thuongHieu ===0){
                    url += '/admin/product/all';
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        })
                }
            }
        },
        created() {
            this.getLoaiSP();
            this.getThuongHieu();
        }
    }
</script>