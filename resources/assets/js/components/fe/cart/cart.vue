<template>
    <div>

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Giỏ hàng</h1>
        </div>
    </section>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Tên Sản Phẩm</th>
                            <th scope="col">Tình Trạng</th>
                            <th scope="col" class="text-center">Số Lượng</th>
                            <th scope="col" class="text-right">Giá</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item,index in carts">
                            <td><img :src="'/admin_asset/upload/'+item.options['Thumbnail']" style="width: 100px" /> </td>
                            <td>{{item.name}}</td>
                            <td>Còn hàng {{index}}</td>
                            <td><input class="form-control" v-on:keyup="soLuongChange()" type="text" v-model="item.qty"/></td>
                            <td class="text-right">{{item.price}} VNĐ</td>
                            <td class="text-right"><button class="btn btn-sm btn-danger" @click.prevent="deleteFromCart(item.rowId,index)"><i class="fa fa-trash"></i> </button> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>{{total}} VNĐ</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <button class="btn btn-block btn-light">Tiếp Tục Mua Sắm</button>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <button class="btn btn-lg btn-block btn-success text-uppercase" @click="thanhToan">Thanh Toán</button>
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
                carts:[],
                total:'',
                postData:[],
                isLogin:false,
                user:{},
            }
        },
        mounted() {
            var app = this;
            axios.get('/cart/content')
                .then(function (response) {
                    app.carts = response.data;
                })
                .catch(function (response) {
                });
            axios.get('/cart/total')
                .then(function (response) {
                    app.total = response.data;
                })
                .catch(function (response) {
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
            deleteFromCart(rowId,index){
                var app = this;
                axios.get('/cart/delete/'+rowId)
                    .then(function (response) {
                        app.carts = response.data;
                        axios.get('/cart/total')
                            .then(function (response) {
                                app.total = response.data;
                            })
                            .catch(function (response) {
                            });
                    })
                    .catch(function (response) {
                    });
            },
            thanhToan(){
                var app = this;
                var postData = [];
                postData[0] = app.carts;
                postData[1] = app.total;
                if(app.isLogin == true){{

                    axios.post('/payment',postData)
                        .then(function (response) {
                            alert('Thanh toán thành công');
                            app.carts =[];
                            app.total = 0;
                            window.location.href = '/';
                        })
                        .catch(function (response) {

                        });
                }}
                else{
                    window.location.href = '/client/login';
                }
            },
            soLuongChange(){
                var app = this;
                var postData = app.carts;
                axios.post('/cart/update',postData)
                    .then(function (response) {
                        app.total = response.data;
                    })
                    .catch(function (response) {

                    });
            }
        }
    }
</script>