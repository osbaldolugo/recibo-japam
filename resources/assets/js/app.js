
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var user_id = $("#user_Id").val();
var page = $("#page").data("url");

const app = new Vue({
    // A DOM element to mount our view model.
    el: '#app',
    // Define properties and give them initial values.
    data:{
        message: 'You loaded this pagge on '+ new Date().toLocaleString()
    },
    created(){
        Echo.channel('USER.'+user_id).listen('Push', (e) => {
            var num_child = $("#notificaciones").children().length;
            if(num_child > 6){
                var child_delete = parseInt(num_child)-2;
                $("#notificaciones li").eq(child_delete).remove();
            }
            var notificaciones_text = $("#notificaciones_number").data("count");
            var notificaciones = parseInt(notificaciones_text) + 1;
            $("#notificaciones_number").data("count",notificaciones).text(notificaciones);

            $("#notificaciones li:nth-child(1)").after(e.comment.html_notification);

            $.gritter.add({
                title: "Notificación",
                text: e.comment.content,
                image: page + "/img/icon_japam.png",
                sticky:!1,
                time:""
            });

        });
    }
});