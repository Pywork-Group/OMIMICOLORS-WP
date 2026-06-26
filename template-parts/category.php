<?php
	$category = $args['category'] ?? null;
	if ( ! $category ) return;

	$class = $args['class'] ?? '';

	$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
	$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : false;
?>

<li class="category <?php echo esc_attr( $class ); ?>">
	<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category__card">

		<?php if ( $image_url ) : ?>
			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
		<?php endif; ?>
		<div class="category__box">
			<h3 class="category__name"><?php echo esc_html( $category->name ); ?></h3>
			<?php if ( !empty( $category->description ) ) : ?>
			<p class="category__description"><?php echo esc_html( $category->description ); ?></p>
			<?php endif; ?>
		</div>
	</a>
</li>