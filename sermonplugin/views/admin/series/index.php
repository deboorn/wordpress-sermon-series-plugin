<?php
if (!function_exists('add_action')) exit();
wp_enqueue_script('jquery');
?>


<div class="wrap">
    <h2>
        Manage Sermon Series
        <a href="?page=series-index&action=new-series" class="add-new-h2">Add New</a>
    </h2>
    <form method="get">
        <input type="hidden" name="page" value="series-index" />
        <?php $spTable->search_box('search', 'search_id'); ?>
    </form>
    <?php $spTable->display(); ?>


    <div style="background-color: #FFF; padding:5px 10px 10px 10px;">
        <h3>How to Use Plugin & Shortcodes</h3>
        <ul>
            <li>
                <strong>Step 1:</strong>
                <code>[sermonplugin_series_index sermonpageurl="url-to-sermon-page" columns="1|2|3" limit="100"]</code>
                <br>
                -- Place this shortcode on page to display searchable list of series.<br>
                -- Attribute <code>sermonpageurl</code> should contain a the page URL to the sermon page (required).<br>
                -- Attribute <code>columns</code> should contain number of columns. A value of 1 or 2 or 3 is supported.<br>
                -- Attribute <code>limit</code> should contain the max amount of series to display (newest displayed first).<br>
            </li>
            <li>
                <strong>Step 2:</strong>
                <code>[sermonplugin_watch_sermon]</code>
                <br>
                -- Place this shortcode on page to load sermon when linked from series index short code above
            </li>
            <li>
                <strong>Optional</strong>
                <code>[sermonplugin_current_series sermonpageurl="url-to-sermon-page"]</code><br>
                -- Place this shortcode on any page to display current series linked to watch sermon page.<br>
                -- Attribute <code>sermonpageurl</code> should contain a the page URL to the sermon page (required).<br>
            </li>
            <li>
                <strong>Optional: Link to Current Series</strong>
                <code>url-to-sermon-page/?series=current</code><br>
                -- Add <code>series=current</code> to watch sermon page URL.<br>
                -- Where <code>url-to-sermon-page</code> is the URL to your WP sermon page.
            </li>
        </ul>
    </div>

</div>



<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".del-btn").click(function () {
            if(confirm('Are you sure you want to delete series? Warning: Deleting series will delete all sermons under series.')){
                return true;
            }
            return false;
        });
    });
</script>
