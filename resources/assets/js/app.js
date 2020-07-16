
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import productsIndex from './components/products/productsIndex.vue';
import productsCreate from './components/products/productsCreate.vue';
import productsEdit from './components/products/productsEdit.vue';
import productsDetail from './components/products/productsDetail';
import productsIndexFE from './components/fe/products/productsIndexFE';
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
const routes = [
    {
        path: '/',
        components:{
            productsIndex:productsIndex,
            productsCreate: productsCreate,
            productsEdit:productsEdit,
            productsDetail:productsDetail,
            productsIndexFE:productsIndexFE
        }
    },
]
Vue.component('image-component',require('./components/products/uploadImage.vue'))
Vue.component('create-product',require('./components/products/productsCreate'))
Vue.component('index-product',require('./components/fe/products/productsIndexFE'))
Vue.component('index-cart',require('./components/fe/cart/cart'))
Vue.component('index-header',require('./components/fe/layout/header'))
Vue.component('index-hoadons',require('./components/hoadons/hoadon'))
Vue.component('index-thanhtoans',require('./components/thanhtoans/thanhtoan'))
Vue.component('detail-thanhtoan',require('./components/thanhtoans/detail'))
Vue.component('index-loaisanpham',require('./components/loaisanpham/index'))

Vue.component('index-deleted',require('./components/products/deleted'))
Vue.component('index-khachhang',require('./components/khachhang/index'))
Vue.component('index-khuyenmai',require('./components/khuyenmai/index'))
Vue.component('index-trahang',require('./components/trahang/trahang'))
Vue.component('index-thuonghieu',require('./components/thuonghieu/index'))
Vue.component('index-doanhthu',require('./components/doanhthu/doanhthu'))
Vue.component('detail-sanpham-fe',require('./components/fe/products/detail'))
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );

import VueMask from 'v-mask'
Vue.use(VueMask);
const router = new VueRouter({routes})
const app = new Vue({router}).$mount('#app')

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

