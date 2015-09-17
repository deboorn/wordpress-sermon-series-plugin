<?php
if (!function_exists('add_action')) exit();
wp_enqueue_script('jquery');
wp_enqueue_media();
?>

<div class="wrap">
    <h2>Edit Sermon (Sermon Series: <?php echo $series->title; ?>)</h2>
    <p>Complete form below to update the sermon.</p>
    <?php echo $_form; ?>
</div>
