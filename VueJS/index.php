<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <div id="myapp">
        {{thongbao}}
    </div>
    <div id="myApp2">
        <h2>{{topic}}</h2>
        <ul>
            <li>
                {{array[1]}}
            </li>
            <li>
                {{object.name}}
            </li>
        </ul>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
        el:"#myapp",
        data:{
            thongbao:'Hello World'
        }
    })
    var myApp2 = new Vue({
       el:"#myApp2",
       data:{
           topic:'Kieu du lieu trong vuejs',
           array:['zet','linh','mai'],
           object:{name:'nguyen van a',age:22}
       }
    });
</script>
</html>