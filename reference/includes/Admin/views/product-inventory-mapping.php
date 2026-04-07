<?php
$response = rnb_get_inventory_by_product($post->ID);
?>

<?php if (empty($response['success'])) : ?>
    <p><?php echo esc_attr($response['message']); ?></p>
<?php endif; ?>

<?php if (!empty($response['success'])) : ?>
    <?php $inventory_ids = $response['inventories']; ?>
    <div class="product-list">
        <ul class="list">
            <?php foreach ($inventory_ids as $product_id) : ?>
                <li><a href="<?php echo esc_url(get_edit_post_link($product_id)); ?>"><?php echo get_the_title($product_id); ?> </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>