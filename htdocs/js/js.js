
function elementa_novietosana_vidu(attels,elements){
    var x = 0;
    var y = 0;
    var z = 200;
    var scale=0.3;
    attels.setAttribute('data-x', x);
    attels.setAttribute('data-y', y);
    attels.setAttribute('data-z', z);
    attels.setAttribute('data-scale', scale);

    // nomaina attēla pozīciju un izmēru
    elements.css('transform','translate3d(' + x + 'px, ' + y + 'px, '+z+'px) scale('+scale+')');
    var atstarpe = 15*(3-elements.height() / elements.width());
    elements.css('top',atstarpe+'%');
}

$('document').ready(function(){

    document.querySelectorAll(".paralaks_grupa").forEach(parallaxWrap =>
        parallaxWrap.addEventListener("mousemove", ({ clientX, clientY }) => {
            parallaxWrap.style.setProperty("--x", clientX);
            parallaxWrap.style.setProperty("--y", clientY);
        })
    );
  
  
    // kreisā puse
    $( ".attels_izdzest" ).click(function() {
        var attela_opcijas = $(this).parent().parent();
        var index = attela_opcijas.index();
        attela_opcijas.removeClass('redzams');
        var elements = $(".paralaks_grupa").children().eq(index);
        var attels = elements[0];
        elements.removeClass('redzams');
        elementa_novietosana_vidu(attels,elements);
    });
  
    $( ".attela_opcijas" ).click(function(e) {
        // pārbauda vai tika uzspiests uz kopējā elementa
        if($(e.target).is("div")) {
            $(this).addClass('redzams');
            var index = $(this).index();
            var elements = $(".paralaks_grupa").children().eq(index);
            elements.addClass('redzams');
        }
    });
  
    $( ".attela_izmers" ).each(function() {
        var attela_izmers = $( this );
        attela_izmers.on("input", function() {
            var index = $(this).parent().index();
            var elements = $(".paralaks_grupa").children().eq(index);
            var attels = elements[0];
            var x = attels.getAttribute('data-x');
            var y = attels.getAttribute('data-y');
            var z = attels.getAttribute('data-z');
            var scale;
            if($(this).val() <= 50){
            scale=$(this).val() / 200 + 0.04;
            }else{
            scale = $(this).val() / 200 + ($(this).val() - 50)/50;
            }
            attels.setAttribute('data-scale', scale);
            // nomaina attēla pozīciju un izmēru
            elements.css('transform','translate3d(' + x + 'px, ' + y + 'px, '+z+'px) scale('+scale+')');
        });
    });
    $( ".attela_attalums" ).each(function() {
        var attela_izmers = $( this );
        var index = attela_izmers.parent().index();
        var elements = $(".paralaks_grupa").children().eq(index);
        var attels = elements[0];
        elementa_novietosana_vidu(attels,elements);
        
        attela_izmers.on("input", function() {
            var index = $(this).parent().index();
            var elements = $(".paralaks_grupa").children().eq(index);
            var attels = elements[0];
            var x = attels.getAttribute('data-x');
            var y = attels.getAttribute('data-y');
            var scale = attels.getAttribute('data-scale');
            var z = ($(this).val())*4;
            attels.setAttribute('data-z', z);
            // nomaina attēla pozīciju un izmēru
            elements.css('transform','translate3d(' + x + 'px, ' + y + 'px, '+z+'px) scale('+scale+')');
        });
    });

    //fona izvēle
    $(".fons_izvele").click(function () {
        $(".paralaks").css('background', $(this).css('background'));
    });
    // uzstāda pirmo fonu
    $(".paralaks").css('background', $(".fons_izvele").eq(0).css('background'));



    $('#pasakas_teikums span').click(function () {
        //vārda definēšanas forma
        var varda_index = $(this).index();
        // noņem liekus simbolus no vārda
        $('#varda_definesana_vards').text($(this).text().replace(/[^a-zA-ZāĀčČēĒīĪķĶļĻņŅšŠūŪžŽ]/g, ''));
        $('#nominativs').val($('#varda_definesana_vards').text());
        $('#uzspiestais_vards').val(varda_index);
        $('#definesana').show();
        $('#forma_fons').hide();
        $('#forma_vards').show();
    });
    $('#fona_pievienosana').click(function () {
        $('#definesana').show();
        $('#forma_vards').hide();
        $('#forma_fons').show();
    });
    $('#paslept_varda_definesana').click(function () {
        $('#definesana').hide();
        $('#forma_fons').hide();
        $('#forma_vards').hide();
    });

});

function dragMoveListener (event) {
    var target = event.target;
    // iegūst attēla pozīciju un izmēru
    var z = (parseFloat(target.getAttribute('data-z')) || 200);
    var scale = (parseFloat(target.getAttribute('data-scale')) || 0.5);
    var paatrinatajs = (z/650).toFixed(2);
    var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx * (1-paatrinatajs);
    var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy * (1-paatrinatajs);
  
    // nomaina attēla pozīciju un izmēru
    target.style.transform = 'translate3d(' + x + 'px, ' + y + 'px, '+z+'px) scale('+scale+')';
  
    // saglabā attēla pozīciju
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

// sagatavo funkciju attēlu pozicijas un izmēru mainīšanai
window.dragMoveListener = dragMoveListener;

interact('.resize-drag')
    .draggable({
    listeners: {
        move: window.dragMoveListener },
    inertia: true,
    modifiers: [
        interact.modifiers.restrictRect({
        restriction: 'parent',
        endOnly: true
        })
    ]
});