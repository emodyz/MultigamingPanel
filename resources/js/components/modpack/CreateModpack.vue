<template>
    <div id="createModpackModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Modpack</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="alert" class="alert" :class="'alert-' + alert.status || 'warning'" role="alert">
                        <h4 class="alert-heading">{{alert.title}}</h4>
                        <p class="mb-0">
                            {{alert.message}}
                        </p>
                    </div>
                    <fieldset class="form-group">
                        <label for="modpackName">Name</label>
                        <input type="text" class="form-control" id="modpackName" placeholder="Enter modpack name"
                               v-model="name">
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" :class="loading ? 'waves-effect waves-light' : ''" class="btn btn-primary"
                            v-on:click="send">
                        <span v-if="loading" class="spinner-grow spinner-grow-sm" role="status"
                              aria-hidden="true"></span>
                        Create
                    </button>
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
                name: '',
                loading: false,
                alert: null
            };
        },
        methods: {
            send: function () {
                this.loading = true;
                this.alert = null;
                axios.post('/modpacks', {name: this.name})
                    .then(() => {
                        this.alert = {
                            title: 'Success',
                            message: 'Modpack created with success',
                            status: 'success'
                        };
                        setTimeout(() => {
                            $('#createModpackModal').modal('toggle');
                        }, 1000);
                    })
                    .catch(err => {
                        const message = (err.response && err.response.data && err.response.data.message) ?
                            err.response.data.message : err;
                        this.alert = {
                            title: 'Error',
                            status: 'danger',
                            message: message
                        };
                    }).finally(() => this.loading = false);
            }
        }
    }
</script>

<style scoped>

</style>
