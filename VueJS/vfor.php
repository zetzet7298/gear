<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="myApp">
    <h2>DSSV</h2> {{array}}
    <ul>
        <li v-for="(item,index) in array">{{index}}: {{item}}</li>
    </ul>
    <br>
    <ul>
        <li v-for="(item,index) in ngonngu">{{index}}: {{item.name}}</li>
    </ul>
    <button @click="themDL">Them dl</button>
    <button @click="xoaDL">Xoa dl</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
       el:'#myApp',
       data:{
           array:['zet','linh','mai'],
           ngonngu:[
               {name:'PHP'},
               {name:'JS'},
               {name:'PHP'},
               {name:'C#'}
           ]
       },
        methods:{
           themDL:function () {
                this.ngonngu.push({name:'ReactJS'});
           },
            xoaDL:function () {
                this.ngonngu.shift();
            }
        }
    });
</script>
</body>
</html>