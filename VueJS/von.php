<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="myApp">
    <button v-on:click="doIt">v-on click</button>
    <button v-on:dblclick="doIt">v-on double click</button>
    <button v-on:mouseenter="doIt">v-on mouseenter</button>
    <button v-on:mouseover="doIt">v-on mouseover</button>
    <h2 v-text="content" v-on:click="changeContent"></h2>
    <h2></h2>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
        el:'#myApp',
        data:{
            content:'zet'
        },
        methods:{
            doIt:function () {
                alert('This is alert');
            },
            changeContent:function () {
                this.content += ' ne';
            }
        }
    })
</script>
</body>
</html>