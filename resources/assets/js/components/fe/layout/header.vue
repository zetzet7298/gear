<template>
    <div>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li v-if="isLogin == false"><a href="/client/login"><i class="fa fa-user-o"></i> Đăng nhập</a></li>
                <li v-if="isLogin == true"><span style="color: white;font-weight: bold"> Xin chào {{user.HoTen}}</span></li>
                <li v-if="isLogin == true"><a href="/client/logout"><i class="fa fa-user-o"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="#" class="logo">
                            <img src="/img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <form>
                            <select class="input-select">
                                <option value="0">Tên Sản Phẩm</option>
                                <option value="1">Loại Sản Phẩm</option>
                                <option value="1">Thuơng Hiệu</option>
                            </select>
                            <input class="input" v-model="searchTenSP" v-on:keyup="search" placeholder="Search here">
                            <button class="search-btn">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <ul id="myMenu" style="position: absolute;background-color: white;margin-left: 310px;margin-top: 55px; width: 450px;">
                    <li v-for="item in products">
                        <a :href="'/product/view/'+item.MaSP" style="padding-bottom: 10px;">
                            <img :src="'/admin_asset/upload/'+item.Thumbnail" width="100px;">
                            {{item.TenSP}}
                            {{item.Gia}}<sup>đ</sup>
                        </a>
                    </li>
                </ul>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div class="dropdown">
                            <a href="/cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Giỏ Hàng</span>
                                <div class="qty">{{count}}</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="/img/product01.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>

                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="/img/product02.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small>3 Item(s) selected</small>
                                    <h5>SUBTOTAL: $2940.00</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="#">View Cart</a>
                                    <a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    </div>
</template>
<script>
    export default {
        data:function () {
            return{
                count:'',
                isLogin:false,
                user:{},
                searchTenSP:'',
                products:[]
            }
        },
        mounted() {
            var app = this;
            axios.get('/cart/count')
                .then(function (response) {
                    app.count = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                    alert("Could not load products")
                });
            axios.get('/user')
                .then(function (response) {
                    app.user = response.data;
                    if(response.data != 'Câu truy vấn bị sai'){
                        app.isLogin = true;
                    }
                })
                .catch(function (response) {
                });
        },
        methods:{
            search:function () {
                var app = this;
                var url ='';
                if(app.searchTenSP){
                    url = '/admin/product/search?TenSP='+app.searchTenSP;
                    axios.get(url)
                        .then(function (response) {
                            app.products = response.data;
                            console.log(response.data);
                        })
                        .catch(function (response) {

                        })
                }
            }
        }
    }
</script>