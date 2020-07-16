<template>
    <div class="form-group">
        <label class="control-label" for="thumbnail">Thumbnail:</label>

        <input type="file" id="thumbnail" v-on:change="onFileChange" class="form-control" />
        <span id="store_imgNho"></span>
        <div class="help-block with-errors"></div>

        <button @click="uploadImage" class="btn crud-submit btn-success">Upload Image</button>

    </div>
</template>
<script>
    export default {
        data:function () {
            return {
                image:''
            }
        },
        methods:{
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){

            }
        }
    }
</script>