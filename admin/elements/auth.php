<?php
if (isset($_SESSION['user_id'])) {

    var_dump($_SESSION['user_id']);
    var_dump($_SESSION['user_type']);   

    if ($_SESSION['user_type'] == 'admin') { ?>
        <script>
            var auth_level = 3;
        </script>
    <?php } ?>

    <?php if ($_SESSION['user_type'] == 'regular') {
    ?>
        <script>
            var auth_level = 1;
        </script>


        <?php if ($_SESSION['isPM']) { ?>
            <script>
                var auth_level = 2;
            </script>
<?php }
    }
} ?>