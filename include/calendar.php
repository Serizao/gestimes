<link rel="stylesheet" href="css/monthly.css">

<div class="col-md-12">
        <div style="width:100%; max-width:1300px; display:inline-block;">
            <div class="monthly" id="mycalendar2"></div>
        </div>
</div>
<!-- JS ======================================================= -->
<script type="text/javascript" src="js/monthly.js"></script>
<script type="text/javascript">
    $(window).load( function() {
        $('#mycalendar2').monthly({
            mode: 'event',
            xmlUrl: 'include/generateevent.php'
        });
        switch(window.location.protocol) {
        case 'http:':
        case 'https:':
        // running on a server, should be good.
        break;
        case 'file:':
        }
    });
</script>

