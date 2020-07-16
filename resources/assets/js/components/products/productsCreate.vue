<template>
    <div>
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
    </div>
</template>
<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        mounted() {
            console.log('Component mounted')
        },
        data:function () {
            return {
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
                    LoaiSP:'',
                    ThuongHieu:'',
                    photo:''
                }),
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    // The configuration of the editor.
                }
            }
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
                let photo = (this.product.photo.length > 100) ? this.product.photo : "img/profile/"+ this.product.photo;
                return photo;
            },
        },
        created:function(){
            this.getLoaiSP();
            this.getThuongHieu();
        }
    }
</script>