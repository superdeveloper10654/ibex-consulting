<script>
    $( ".score-table td.selectable" ).click(function() {
        $('.score-table td.selectable').removeClass('selected');
        $(this).addClass('selected');
        $('#score_order').val($(this).data('order'));
        $('#risk_score').val($(this).html());
    });
</script>