//almacenar slider y botones en variables
var slider=$('#slider');
var siguiente =$('#btn-next');
var anterior =$('#btn-prev');
var interval;
//mover la ultima imagen al primer lugar
$('#slider section:last').insertBefore('#slider section:first');

//mostrar la primera imagen con margen de -100%
slider.css('margin-left', '-'+100+'%');

function moverD() {
    slider.animate({marginLeft:'-'+200+'%'}, 700, function(){
        $('#slider section:first').insertAfter('#slider section:last');
        slider.css('margin-left', '-'+100+'%');
    });
}
function moverI() {
    slider.animate({marginLeft:'-'+0+'%'}, 700, function(){
        $('#slider section:last').insertBefore('#slider section:first');
        slider.css('margin-left', '-'+100+'%');
    });
}

siguiente.on('click', function() {
    moverD();
});

anterior.on('click', function() {
    moverI();
});

function autoplay() {
    interval = setInterval(function () {
        moverD();
    }, 3000);
}

function pausa(){
    let btn_pausa = document.getElementById('btn-pausa');
    let texto = btn_pausa.title;
    console.log(texto);
    //console.log(texto ==="Pausa");
    if(texto=="Pausa"){
        btn_pausa.title = "Play";
        btn_pausa.innerHTML = '<i class="fa fa-play"></i>';
        window.clearInterval(interval);
    }
    else{
        autoplay();
        btn_pausa.title = "Pausa";
        btn_pausa.innerHTML = '<i class="fa fa-pause"></i>';
    }

}

autoplay();