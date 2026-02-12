<template>
    <div v-if="merge_son.length == 0">
        <div class="panel-toolbar">
            <form method="POST" v-on:submit.prevent="sendComment" :action="route_store">
                <div class="form-group">
                    <textarea id="txtCommentContent" class="form-control bg-silver summernote-editor" placeholder="Ingresa tu mensaje..." v-model="content" @keyup.alt.enter="sendComment"></textarea>
                </div>
                <span class="input-group-btn">
                    <a href="javascript:;" id="btnSave" class="btn btn-primary btn-block" @click="sendComment"><i class="fa fa-send"></i></a>
                </span>
            </form>
        </div>
    </div>
</template>

<script>
    export default ({
        props: ['route_store', 'merge_son', 'ticket_id'],
        data () {
            return {
                content: ''
            }
        },
        methods: {
            sendComment: function() {
//                $.setLoading($("#comments"), "Espere un momento...");
                axios.post(this.route_store, {
                    ticket_id: this.ticket_id,
                    content: this.content
                }).then(responses => {
                    //this.getComments();
                    this.content = '';
//                    $($("#comments")).unblock();
//                    sendCommentSummernote();
                }).catch(error => {
                    swal({
                        title: 'Error',
                        text: 'No fue posible enviar tu comentario',
                        type: "error",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                    //$($("#comments")).unblock();
                });
            }
        }
    });
</script>