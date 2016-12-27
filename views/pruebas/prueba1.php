<?php

use yii\helpers\Url

?>
<a href="#" id="prueba">Prueba</a>
<div class="ajax-content">
    
</div>


<script type="text/javascript">
    $(document).ready(function(){
       $('#prueba').on('click',function(){
          $.ajax({
            url: '<?= Url::toRoute(['pruebas/prueba2']); ?>',
            success: function(data) {
                $('.ajax-content').html(data);
            }
         });
       });
    });
</script>