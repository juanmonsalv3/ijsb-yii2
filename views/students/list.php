<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Estudiantes';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('students/')];
?>

<div class="col-xs-6">
	<?= Html::dropDownList('group-filter', null, $grupos, ['id' => 'group-filter', 'class' => 'form-control','prompt' => 'Filtrar por Grupo'])?>
</div>
<div class="col-xs-6">
	<div class="input-group">
		<?= Html::textInput('search-filter', null, ['id' => 'search-filter', 'class' => 'form-control', 'placeholder' => 'Buscar por nombre'])?>
		<span class="input-group-btn">
			<button class="btn btn-default hide" type="button" id="clear-search-button">
	       		<span class="glyphicon glyphicon-remove"></span>
	        </button>
	        <button class="btn btn-default" type="button" id="search-button">
	       		<span class="glyphicon glyphicon-search"></span>
	        </button>
      	</span>
	</div>
</div>
<div class="col-xs-12">
	<table id="students" class="table table-responsive table-hover table-striped datatable" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Nombres</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>

<script>
	$(document).ready(function() {
		var optionsContent = '<div class="dropdown">';
  		optionsContent += '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
    	optionsContent += 'Opciones <span class="caret"></span>';
  		optionsContent += '</button>';
  		optionsContent += '<ul class="dropdown-menu">';
		optionsContent += '<li><?= Html::a('Ver Estudiante', Url::toRoute(['students/view','id'=>'-id-'])) ?></li>';
	    optionsContent += '<li role="separator" class="divider"></li>';
	    optionsContent += '<li><?= Html::a('Boletin', Url::toRoute(['students/grades-report','id'=>'-id-'])) ?></li>';
	  	optionsContent += '</ul>';
		optionsContent += '</div>';

		$.extend( dt_config, {
			"ajax": {
	            "url": "students/list",
	            "type": "POST",
	            "data": function ( d ) {
	                d.search = $('#search-filter').val();
	                d.group = $('#group-filter').val();
            	}
		    },
			"columns": [
		            { "data": "grupo" },
		            { "data": "nombres" },
		            {
		            	"className": "td-options-dropdown",
		                "orderable":false,
		                "render": function ( data, type, row ) {
		                    return replaceAll(optionsContent, '-id-', row['id_estudiante']);
		                },
		            }

		        ],
		    "order": [[ 0, "asc" ]],
		} );

	    var table = $('#students').DataTable( dt_config );

	    $('#search-button').click(function(){
	    	table.draw();
	    });

	    $('#group-filter').on('change',function(){
	    	table.draw();
	    });

	    $('#search-filter').on('keyup',function(e){
	    	if($('#search-filter').val().length == 0){
	    		$("#clear-search-button").addClass("hide");
	    	}
	    	else{
	    		$("#clear-search-button").removeClass("hide");
	    	}

	    	if(e.keyCode == 13){
	    		table.draw();
	    	}
	    });

	    $("#clear-search-button").click(function(){
	    	$('#search-filter').val("");
	    	$("#clear-search-button").addClass("hide");
	    	table.draw();
	    });
	});
</script>