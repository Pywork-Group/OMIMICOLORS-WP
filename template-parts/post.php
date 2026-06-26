<?php
$post = $args['post'] ?? null;
if ( ! $post ) return;

$class = $args['class'] ?? '';

$thumbnail_id = get_post_thumbnail_id( $post->ID );
$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : false;

$post_date = get_the_date( 'j F Y', $post );
?>

<li class="post <?php echo esc_attr( $class ); ?>" data-id="<?php echo esc_attr( $post->ID ); ?>">
    <a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="post__card">
        
        <?php if ( $image_url ) : ?>
            <div class="post__thumbnail">
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
            </div>
        <?php endif; ?>

        <div class="post__box">
					<div class="post__box-details">
						<h3 class="post__box-name"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
            <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                <p class="post__box-excerpt"><?php echo esc_html( $post->post_excerpt ); ?></p>
            <?php else : ?>
                <p class="post__box-excerpt"><?php echo wp_trim_words( wp_strip_all_tags( $post->post_content ), 20 ); ?></p>
            <?php endif; ?>
					</div>
            <div class="post__box-date">
                <?php echo esc_html( $post_date ); ?>
            </div>
        </div>
    </a>
</li>