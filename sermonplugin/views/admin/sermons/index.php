<?php
if (!function_exists('add_action')) exit();
wp_enqueue_script('jquery');
?>

<div class="wrap">
    <h2>
        Manage Sermons
        <a href="?page=series-index&action=new-sermons&series_id=<?php echo $series->id; ?>" class="add-new-h2">
            Add New</a>
    </h2>

    <h3 style="margin:0px 0px 10px 0px;">Sermon Series: <?php echo $series->title; ?></h3>

    <form method="get">
        <input type="hidden" name="page" value="series-index"/>
        <?php $spTable->search_box('search', 'search_id'); ?>
    </form>
    <?php $spTable->display(); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".del-btn").click(function () {
            if(confirm('Are you sure you want to delete sermon?')){
                return true;
            }
            return false;
        });
    });
</script>


