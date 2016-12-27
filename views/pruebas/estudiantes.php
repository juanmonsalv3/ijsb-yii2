
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>

<script>
	$(document).ready(function() {
	    var table = $('#example').DataTable( {
	        "ajax": "../pruebas/testdata",
	        "processing": true,
        	"serverSide": true,
	        "columns": [
	            {
	                "className":      'details-control',
	                "orderable":      false,
	                "data":           null,
	                "defaultContent": ''
	            },
	            { "data": "name" },
	            { "data": "position" },
	            { "data": "office" },
	            { "data": "salary" }
	        ],
	        "order": [[1, 'asc']],
	        "paging": true
	    } );
	});
</script>