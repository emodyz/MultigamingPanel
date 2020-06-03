<template>
    <div class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create Modpack</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label for="modpackName">Name</label>
                        <input type="text" class="form-control" id="modpackName" placeholder="Enter modpack name"
                               v-model="name">
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="send">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CreateModpack",
        data: () => {
            return {
                name: ''
            };
        },
        methods: {
            send: function() {
                axios.post('/modpacks', {name: this.name})
                    .then(res => console.log(res))
                    .catch(err => console.error(err))
            }
        }
    }
</script>

<style scoped>
    @import "/css/plugins/forms/wizard.css";

</style>
