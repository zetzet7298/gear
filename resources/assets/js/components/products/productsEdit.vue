<template>
    <form class="form-sua" data-toggle="validator">
        <input type="text" id="id" name="MaSP">
        <div class="form-group">
            <label class="control-label" for="tenSanPham">Tên Sản Phẩm:</label>

            <input type="text" id="tenSanPham" v-model="product.TenSP" class="form-control"  />

            <div class="help-block with-errors"></div>

        </div>
        <div class="form-group">
            <label class="control-label" for="tomTat">Tóm tắt:</label>

            <input type="text" id="tomTat" v-model="product.TomTat" class="form-control"  />

            <div class="help-block with-errors"></div>

        </div>
        <div class="form-group">
            <label class="control-label" for="gia">Giá:</label>

            <input type="text" id="gia" v-model="product.Gia" class="form-control"  />

            <div class="help-block with-errors"></div>

        </div>
        <div class="form-group">
            <label class="control-label" for="thongTin">Thông Tin:</label>

            <textarea id="thongTin" v-model="product.ThongTin" class="form-control ckeditor" ></textarea>

            <div class="help-block with-errors"></div>

        </div>
        <div class="form-group">
            <label class="control-label" for="noiDung">Nội Dung:</label>

            <textarea id="noiDung" v-model="product.NoiDung" class="form-control ckeditor"  ></textarea>

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
            <button type="submit" @click.prevent="saveForm" class="btn crud-submit btn-success">Sửa</button>

        </div>

    </form>
</template>
<script>
    export default {
        data:function () {
            return {
                product: new Form({
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    TenSP:'',
                    Gia:'',
                    NoiDung:'',
                    ThongTin:'',
                    TomTat:'',
                    SoLuongTon:'',
                    photo:'',
                    MaSP:''
                }),
            }
        },
        methods:{
            saveForm(){
                //var app = this;
                //var newProduct = app.product;
                var id = this.id;
                alert(this.product.MaSP);
                this.product.put('/admin/product/'+id)
                    .then((response)=>{
                        alert('Đã sửa!');
                        Toast.fire({
                            icon: 'success',
                            title: 'File uploaded successfully'
                        })
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
                let photo = (this.product.photo.length > 100) ? this.product.photo : "img/profile/"+ this.product.photo;
                return photo;
            },
        }
    }
</script>