<?php if (get_header_image()) : ?>
	<div id="site-header">
		<img src="<?php header_image(); ?>"
			width="<?php echo absint(get_custom_header()->width); ?>"
			height="<?php echo absint(get_custom_header()->height); ?>"
			alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
			class="img-fluid"
		>
		<div class="header-text">
			<span class="display-4"><?php bloginfo('name'); ?></span>
		</div>
	</div>
<?php endif; ?>