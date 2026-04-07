<?php
$response = rnb_get_products_by_inventory($post->ID);
?>

<?php if (empty($response['success'])) : ?>
    <p><?php echo esc_attr($response['message']); ?></p>
<?php endif; ?>

<?php if (!empty($response['success'])) : ?>
    <?php $product_ids = $response['product_ids']; ?>
    <div class="product-list">
        <ul class="list">
            <?php foreach ($product_ids as $product_id) : ?>
                <li>
                    <a href="<?php echo esc_url(get_edit_post_link($product_id)); ?>"><?php echo get_the_title($product_id); ?> </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>