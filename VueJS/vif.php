<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="myApp">
    <h2 v-if="isShow">If = true thi show html</h2>
    <h2 v-if="thoitiet>=28">Thoi tiet nong chet di duoc</h2>
    <button>Change status</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
       el:'#myApp',
       data:{
           isShow:true,
           thoitiet:1
       },
        methods:{

        }
    });
</script>
</body>
</html>