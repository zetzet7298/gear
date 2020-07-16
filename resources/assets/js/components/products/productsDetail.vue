<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">

                <div class="row">
                    <div class="tabs_div">
                        <div>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="success">Mã sản phẩm: </td>
                                    <td>{{product.MaSP}}</td>
                                </tr>
                                <tr>
                                    <td class="success">Tên sản phẩm: </td>
                                    <td>{{product.TenSP}}</td>
                                </tr>
                                <tr>
                                    <td class="success">Loại Sản Phẩm: </td>
                                    <td>{{product.TenLoaiSP}}</td>
                                </tr>
                                <tr>
                                    <td class="success">Thương Hiệu: </td>
                                    <td>{{product.TenThuongHieu}}</td>
                                </tr>
                                <tr>
                                    <td class="success">Ảnh thumbnail: </td>
                                    <td><img :src="'/admin_asset/upload/'+product.Thumbnail" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td class="success">Thông Tin: </td>
                                    <td v-html="product.ThongTin"></td>
                                </tr>
                                <tr>
                                    <td class="success">Nội dung: </td>
                                    <td v-html="product.NoiDung"></td>
                                </tr>
                                <tr>
                                    <td class="success">Số Lượng Tồn: </td>
                                    <td>{{product.SoLuongTon}}</td>
                                </tr>
                                <tr>
                                    <td class="success">Lượt Xem: </td>
                                    <td>{{product.LuotXem}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data:function () {
            return{
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                product:{}
            }
        },
        mounted() {
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);
            var app = this;
            axios.get('/admin/product/'+id)
                .then(function (response) {
                    app.product = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load products")
                });
        }
    }
</script>