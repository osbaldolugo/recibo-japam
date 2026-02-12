<template>
    <div v-if="comments.length > 0">
        <ul class="timeline" id="timeList">
            <li v-for="comment in comments">
                <div class="timeline-time">
                    <span class="date f-w-500">{{ comment.created_at.date | moment('dddd') }}</span>
                    <span class="time f-s-12">{{ comment.created_at.date | moment('hh:mm A') }}</span>
                </div>
                <div class="timeline-icon">
                    <a href="javascript:;"><i :class="comment.icon + ' f-s-20'"></i></a>
                </div>
                <div class="timeline-body">
                    <div class="timeline-header">
                        <span class="userimage"><img :src="comment.user.url_image.length > 0 ? image + '/' + comment.user.url_image : image_default" :alt="comment.user.name" :title="comment.user.name"></span>
                        <span class="username">{{ comment.user.name }}<small></small></span>
                        <span class="pull-right">{{ comment.created_at.date | moment('LL') }}</span>
                    </div>
                    <div class="timeline-content" v-html="comment.html"></div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card card-inverse card-primary text-center" v-else>
        <div class="card-block">
            <blockquote class="card-blockquote">
                <p>Aun no se ha registrado actividad para este tiquet</p>
                <footer>
                    Se el primero en participar <cite title="Source Title">en la conversación</cite>
                </footer>
            </blockquote>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');
    require('moment/locale/es');

    Vue.use(require('vue-moment'), {
        moment
    });
//Laravel ECHO, PUSHER
    export default ({
        props: ['route_get', 'ticket_id'],
        data () {
            return {
                comments : [],
                image: '',
                image_default: ''
            }
        },
        created: function () {
            this.getComments();
            Echo.channel('Ticket.' + this.ticket_id).listen('Comments', (e) => {
                this.comments.unshift(e.comment);
            });
        },
        methods: {
            getComments: function() {
                axios.get(this.route_get).then(response => {
                    this.comments = response.data.comments;
                    this.image = response.data.image;
                    this.image_default = response.data.image_default;
                });
            }
        }
    });
</script>