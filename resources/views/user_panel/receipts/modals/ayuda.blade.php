<style>

</style>
<div style="width: 80%; margin: 0 auto" class="modal fade" id="create">
    <div>
        <div class="modal-content">
            <div class="modal-header text-center">
               {{-- <button onclick="ver_video()">ver video</button>
                <button onclick="stopVideo()">stop</button> --}}
                <button onclick="stopVideo()" type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h2>
                    <span style="color: #333399;"><strong>En caso que presentes problemas para realizar tu pago, llama a tu banco y observa el video.</strong></span>
                </h2>
            </div>
            <div class="modal-body">
                <div class="frame" id="player">
                    {{--<iframe style="width: 100%; height:422px"  src="https://www.youtube.com/embed/YaLB8fViL5s?start=2" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
                </div>
                <div style="margin-top: 21px" class="et_pb_row et_pb_row_4">
                    <span><img style="width: 100%; margin-top: 10px;" src="../img/Wallpaper_QR-scaled.jpg" alt=""></span>
                    <span><img style="width: 100%; margin-top: 10px;" src="../img/1jap-1-scaled.jpg" alt=""></span>
                    <span><img style="width: 100%; margin-top: 10px;" src="../img/3d21-scaled.jpg" alt=""></span>
                    <span><img style="width: 100%; margin-top: 10px;" src="../img/pago_3-scaled.jpg" alt=""></span>
                    <span><img style="width: 100%; margin-top: 10px;" src="../img/4jap2-scaled.jpg" alt=""></span>
                </div>
            </div>
            <div class="modal-footer">

                <button onclick="stopVideo()" type="button" class="close" data-dismiss="modal">
                    <span>Cerrar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var noaction= false;

    // 2. This code loads the IFrame Player API code asynchronously.
    function generarPlayer() {
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    };

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '360',
            width: '500',
            videoId: 'YaLB8fViL5s',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
        let iframe = document.querySelector("iframe")
        iframe.style.width = "100%";
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            done = true;
        }
    }
    function stopVideo() {
        player.stopVideo();
        let modal = document.getElementById("modal");
        modal.style.display= "none";
    }

    function ver_video(){
        let modal = document.getElementById("modal");
        modal.style.display= "inherit";
    }
</script>
