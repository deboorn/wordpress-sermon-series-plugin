<?php
if (!function_exists('add_action')) exit();
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_media();
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

?>

<form action="<?php echo SermonPlugin_Router::getUri(); ?>" method="POST">
    <table class="form-table">
        <!-- series-title -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Series Title <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" autocomplete="off"
                       spellcheck="true" id="title" size="30"
                       name="title" placeholder="Enter series title"
                       required="required" value="<?php echo $model->title; ?>">
            </td>
        </tr>
        <!-- /series-title -->
        <!-- series-date -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Series Start Date <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" autocomplete="off" id="form_start_date" size="30"
                       name="start_date" placeholder="Enter Date"
                       required="required" value="<?php echo date_i18n('m/d/Y', $model->start_date ? : time()); ?>">
            </td>
        </tr>
        <!-- /series-date -->
        <!-- series-image -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Series Image <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" name="image" id="image" class="regular-text"
                       placeholder="Select series image"
                       required="required" value="<?php echo $model->image; ?>" autocomplete="off">
                <input type="button" name="upload-btn" id="upload-btn" class="button-secondary"
                       value="Upload Image" style="margin-top: 10px;">

                <div>
                    <img src="<?php echo $model->image; ?>" class="img-preview"
                         style="width:100%; height:auto; max-width: 300px; display: <?php echo $model->image ? 'normal' : 'none'; ?>;"/>
                </div>
            </td>
        </tr>
        <!-- /series-image -->
    </table>

    <div class="submit">
        <button class="button button-primary button-large"
                type="submit"><?php echo $model->id ? "Save" : "Create New"; ?> Series
        </button>
    </div>

</form>

<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $("#form_start_date").datepicker();

        $('#upload-btn').click(function (e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
                .on('select', function (e) {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#image').val(image_url);
                    console.log($(".img-preview"));
                    $(".img-preview").attr('src', image_url).css('display', 'inline');
                });
        });
    });
</script>


