<?php
$items = $args['items'] ?? [];
?>

<ul class="breadcrumb">
    <?php foreach ($items as $index => $item): ?>
			<li class='breadcrumb__item'>
        <?php if (!empty($item['url'])): ?>
            <a class='breadcrumb__item-link' href="<?php echo esc_url($item['url']); ?>">
                <?php echo esc_html($item['label']); ?>
            </a>
        <?php else: ?>
            <span class='breadcrumb__item-current'><?php echo esc_html($item['label']); ?></span>
        <?php endif; ?>

        <?php if ($index < count($items) - 1): ?>
            <span class='breadcrumb__item-separator'> / </span>
        <?php endif; ?>
			</li>
    <?php endforeach; ?>
</ul>