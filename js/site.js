var dt_config = {
    "dom":"<tp>",
    "processing": true,
    "serverSide": true,
    "order": [[1, 'asc']],
    "paging": true,
    "pagingType": "full_numbers",
    "language": {
        "zeroRecords": "No se encontraron registros",
        "infoEmpty": "No se encontraron registros",
        "search": "Buscar: ",
        "paginate": {
            "first":      "<span class='glyphicon glyphicon-step-backward'></span>",
            "last":       "<span class='glyphicon glyphicon-step-forward'></span>",
            "next":       "<span class='glyphicon glyphicon-chevron-right'></span>",
            "previous":   "<span class='glyphicon glyphicon-chevron-left'></span>"
        },
    }
};

$(document).ready(function(){
    $('.navbar-toggle').on('click',function(e){
        e.preventDefault();
        $('.container').toggleClass('collapsed');
    });
    $('.content').on('click',function(){
        $('.container').removeClass('collapsed');
        $('.navbar-toggle').removeClass('collapsed');
    });
    $('.confirmation').on('click', function () {
    return confirm('¿Está seguro?');
    });
});

function mostrarMensaje(mensaje){
    $('#notify-wrap').notify({ text: mensaje, state: 'ui-state-success', timeout: 3000 });    
}

function mostrarError(error){
    $('#notify-wrap').notify({ text: error, state: 'ui-state-error', timeout: 3000 });    
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, 'g'), replace);
}