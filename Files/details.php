<!-- *** load external page page.htm into div id= div_id  usin jQuery**** -->
<div id="div_id">
    load external html file
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#div_id').click(function() {
            $(this).load('page.htm');
        });
    });
</script>

<!-- Other way -->
<script>
    $(document).ready(function() {
        $('#div_id').load('path/to/page');
    });
</script>

<!-- second way using php -->
<div id="load_content_div"> <?php include "path/to/page"; ?> </div>