<?php
/**
 * Created by PhpStorm.
 * User: michele
 * Date: 14/11/17
 * Time: 8.48
 */

?>

<div class="wrap">
    <h1>Ism Image Download</h1>

    <form method="post" action="">


        <p class="submit"><input type="submit" class="button button-primary"
                                 value="Download"></p>

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="posts_per_page">Url download</label></th>
                <td class="url-row">
                    <input name="url" type="text" class="large-text">
                </td>
            </tr>
            <?php if (isset($attach_id)) : ?>
                <?php foreach ($available_thumbnails as $available_thumbnail) : ?>
                    <tr>
                        <th scope="row"><label for="">Thumbnail "<?php echo $available_thumbnail; ?>"</label></th>
                        <td class="url-row">
                            <img style="max-width: 100%;"
                                 src="<?php echo wp_get_attachment_image_url($attach_id, $available_thumbnail); ?>"/>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>


        <p class="submit"><input type="submit" class="button button-primary"
                                 value="Download"></p></form>
</div>
