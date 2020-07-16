<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="myApp">
    <h2 v-text="html"></h2>
    <h2 v-html="html"></h2>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
        el:'#myApp',
        data:{
            html:'<a href="#">them the a</a>'
        }
    })
</script>
</body>
</html>