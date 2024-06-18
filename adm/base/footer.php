<div style="min-height: 1px; width: 100%; margin: 15px 0"></div>
<script src="<?php echo site_url('adm/')?>assets/js/vendor/foundation.min.js"></script>
<script>
    $(document).foundation();
    $(window).resize(function () {
        show_for_mobile();

    });
    $(function () {
        <?php
        $data = flash_data('data');
        if($data){
        ?>
        $.toast({
            heading: '<?php echo ($data['title'])?>',
            text: '<?php echo ($data['text'])?>',
            icon: '<?php echo ($data['type'])?>',
            position: 'top-right'
        });
        <?php
        }
        ?>
    });

    function show_for_mobile() {
        var mobile = $("#for-mobile");
        if (mobile.is(":visible")) {
            //menu
            var $menu = $("#menu").mmenu({
                extensions: ["position-right","shadow-page"],
            });
            var $icon = $("#bot-menu");
            var API = $menu.data("mmenu");

            $icon.on("click", function () {
                API.open();
            });

            API.bind("open:finish", function () {
                setTimeout(function () {
                    $("#bot-menu").addClass("is-active");
                }, 100);
            });
            API.bind("close:finish", function () {
                setTimeout(function () {
                    $("#bot-menu").removeClass("is-active");
                }, 100);
            });
        }
    }

    show_for_mobile();
</script>
</body>
</html>
