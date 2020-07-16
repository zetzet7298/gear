<template>
    <div class="container_fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="products-details">
                        <h4 href="#Descraption">
                            <strong>Thông số kỹ thuật</strong>
                        </h4>
                        <span v-html="sanpham.ThongTin"></span>
                        <div style="float:left">
                            <img :src="'admin_asset/upload/'+sanpham.Thumbnail" width="300px"/>
                        </div>
                        <div class="products-description">
                            <h5 class="name" style="font-size:200%">
                                {{sanpham.TenSP}}
                            </h5>
                            <p>
                                Trạng thái:
                                <span class=" light-red">
                                        Còn hàng
                    </span><br>
                                Thương hiệu: {{sanpham.TenThuongHieu}}
                            </p>
                            <p>
                                {{sanpham.TomTat}}
                            </p>
                            <hr class="border">
                            <div class="price">
                            Giá:
                                <span class="new_price">
                        {{sanpham.Gia}}
                        <sup>
                          VNĐ
                        </sup>
                      </span>
                            </div>
                            <hr class="border">
                            <div class="wided">

                                    <div class="button_group">
                                        <button class="btn btn-danger" @click="addToCart(sanpham.MaSP)" >
                                            Thêm vào giỏ
                                        </button>

                                    </div>
                            </div>
                            <div class="clearfix">
                            </div>

                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <br>
                    <h4 href="#Descraption">
                        <strong>Thông Tin</strong>
                    </h4>


                    <div class="tab-content-wrap">
                        <div class="tab-content" id="Descraption">
                            <span v-html="sanpham.NoiDung"></span>
                        </div>

                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="clearfix">
                </div>

                <div class="clearfix">
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>

    </div>
</template>
<script>
    export default {
        data:function () {
            return{
                sanpham:{}
            }
        },
        mounted() {
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);
            var app = this;
            axios.get('/product/'+id)
                .then(function (response) {
                    app.sanpham = response.data;
                })
                .catch(function (response) {
                });
        },
        methods:{
            addToCart(MaSP) {
                var app = this;
                axios.get('/cart/add/' + MaSP)
                    .then(function (response) {
                        alert('Đã thêm');
                        location.reload();
                    })
                    .catch(function (response) {

                    });
            }
        }
    }
</script>