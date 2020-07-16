<template>
        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">

                    <!-- section title -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3 class="title">New Products</h3>
                            <div class="section-nav">
                                <ul class="section-tab-nav tab-nav">
                                    <li v-for="item in loaisanphams"><a data-toggle="tab" @click="changeLoaiSP(item.MaLoaiSP)">{{item.TenLoaiSP}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /section title -->

                    <!-- mod -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="products-tabs">
                                <!-- tab -->
                                <div id="tab1" class="tab-pane active">
                                    <div class="products-slick" data-nav="#slick-nav-1">
                                        <div class="col-md-3" v-for="item in products">
                                            <div class="product">
                                                <div class="product-img">
                                                    <img :src="'admin_asset/upload/'+item.Thumbnail" alt="">
<!--                                                    <div class="product-label">-->
<!--                                                        <span class="sale">-30%</span>-->
<!--                                                        <span class="new">NEW</span>-->
<!--                                                    </div>-->
                                                </div>
                                                <div class="product-body">
                                                    <p class="product-category">{{item.TenThuongHieu}}</p>
                                                    <h3 class="product-name"><a href="#">{{item.TenSP}}</a></h3>
                                                    <h4 class="product-price">{{item.Gia}}<sup>đ</sup></h4>
<!--                                                    <del class="product-old-price">$990.00</del>-->
                                                    <div class="product-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="product-btns">
                                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                        <a class="quick-view" :href="'/product/view/'+item.MaSP"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></a>
                                                    </div>
                                                </div>
                                                <div class="add-to-cart">
                                                    <button class="add-to-cart-btn" @click.prevent="addToCart(item.MaSP)"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product -->

                                    </div>
                                    <div id="slick-nav-1" class="products-slick-nav"></div>
                                </div>
                                <!-- /tab -->
                            </div>
                        </div>
                    </div>
                    <!-- Products tab & slick -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->
</template>
<script>
    export default {
        data:function () {
            return{
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
                    MaSP:''
                }),
                MaSP:''
            }
        },
        mounted() {
            var app = this;
            axios.get('/admin/product/paginate')
                .then(function (response) {
                    app.products = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load products")
                });
            axios.get('/admin/loaisp/all')
                .then(function (response) {
                    app.loaisanphams = response.data;
                }.bind(this))
                .catch(function (response) {
                    console.log(response);
                })
        },
        methods:{
            changeLoaiSP(MaSP){
                var app = this;
                axios.get('/admin/loaisp_product/'+MaSP)
                    .then(function (response) {
                        app.products = response.data;
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not load products")
                    });
            },
            addToCart(MaSP){
                var app = this;
                axios.get('/cart/add/'+MaSP)
                    .then(function (response) {
                        alert('Đã thêm');
                        location.reload();
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not load products")
                    });
            }
        }
    }
</script>