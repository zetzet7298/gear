<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="myApp">
    <h2 v-show="isShow">{{content}}</h2>
    <h2 v-show="age>18">{{content}}</h2>
    <h2>{{age}}</h2>
    <button v-on:click="add">Add Age</button>
    <button v-on:click="changeStatus">Change Status</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
        el:'#myApp',
        data:{
            content:'Tren 18 tuoi moi duoc xem',
            age:10,
            isShow:false,
        },
        methods:{
            add:function () {
                this.age++;
            },
            changeStatus:function () {
                this.isShow = !this.isShow;
            }
        }
    })
</script>
</body>
</html>