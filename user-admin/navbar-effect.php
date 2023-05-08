<script>
    $(window).on('load', function() {
        $('#navigation').find('active').removeClass('active');
        $('#navigation').find(`.${activeNav} a`).addClass('active');
    });
</script>