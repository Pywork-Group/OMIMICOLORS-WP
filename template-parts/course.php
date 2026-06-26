<?php
$course_id = $args['course_id'] ?? null;

if (!$course_id) return;

$class = $args['class'] ?? '';

$course_name = carbon_get_post_meta($course_id, 'course_name');
$course_tab = carbon_get_post_meta($course_id, 'course_tab');
$course_image = carbon_get_post_meta($course_id, 'course_image');
$desc1 = carbon_get_post_meta($course_id, 'course_description_1');
$desc2 = carbon_get_post_meta($course_id, 'course_description_2');
$prices = carbon_get_post_meta($course_id, 'course_prices');
$button = carbon_get_post_meta($course_id, 'course_button');
?>

<li class="course <?php echo esc_attr($class); ?>"
	data-name="<?php echo esc_attr($course_name); ?>">

	<div class="course__cols">

		<div class="course__col">
			<?php if ($course_image): ?>
				<?php
				$img_url = wp_get_attachment_url($course_image);
				$img_alt = get_post_meta($course_image, '_wp_attachment_image_alt', true);
				?>
				<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
			<?php endif; ?>
		</div>

		<div class="course__col">
			<?php echo wp_kses_post($desc1); ?>
		</div>

		<div class="course__col">
			<?php echo wp_kses_post($desc2); ?>
		</div>

	</div>

	<div class="course__foot">

		<?php if (!empty($prices)): ?>
			<?php foreach ($prices as $price): 
				$value = (float) $price['course_price_amount'];
			?>
				<div class="course__price">
					<div class="course__amount">
						<i class="fa-solid fa-coins"></i>
						<span>
							<?php echo wc_price($value, [
								'decimals' => ($value == floor($value)) ? 0 : 2
							]); ?>
						</span>
					</div>

					<?php if (!empty($price['course_price_note'])): ?>
						<p class="course__note">
							<?php echo esc_html($price['course_price_note']); ?>
						</p>
					<?php endif; ?>

				</div>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ($button): ?>
			<button class="course__button">
				<span><?php echo esc_html($button); ?></span>
				<i class="fa-solid fa-arrow-right-long"></i>
			</button>
		<?php endif; ?>

	</div>

</li>