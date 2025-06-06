<?php

$all_post_types = [
	'post' => __('Posts', 'blocksy-companion')
];

if (class_exists('WooCommerce')) {
	$all_post_types['product'] = __('Products', 'blocksy-companion');
}

if (blc_theme_functions()->blocksy_manager()) {
	$post_types = blc_theme_functions()->blocksy_manager()->post_types->get_supported_post_types();

	foreach ($post_types as $single_post_type) {
		$post_type_object = get_post_type_object($single_post_type);

		if (! $post_type_object) {
			continue;
		}

		$all_post_types[
			$single_post_type
		] = $post_type_object->labels->singular_name;
	}
}

$cpt_options = [];
$taxonomy_picker_options = [];

foreach ($all_post_types as $custom_post_type => $label) {
	if ($custom_post_type === 'page') {
		continue;
	}

	$opt_id = 'trending_block_category';
	$label = __('Category', 'blocksy-companion');
	$label_multiple = __('All categories', 'blocksy-companion');
	$taxonomy = ['category'];

	if ($custom_post_type !== 'post') {
		$opt_id = 'trending_block_' . $custom_post_type . '_taxonomy';
		$label = __('Taxonomy', 'blocksy-companion');
		$label_multiple = __('All taxonomies', 'blocksy-companion');

		$taxonomies = get_object_taxonomies($custom_post_type);

		if (count($taxonomies) > 0) {
			$taxonomy = array_slice($taxonomies, 0, 20);
		} else {
			$taxonomy = 'nonexistent';
		}
	}

	$categories = get_terms([
		'taxonomy' => $taxonomy,
		// 'post_type' => $custom_post_type,
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => false
	]);

	$category_choices = [
		'all_categories' => $label_multiple
	];

	if (! is_wp_error($categories)) {
		foreach ($categories as $category) {
			$category_choices[$category->term_id] = $category->name;
		}
	}

	$cpt_options[blocksy_rand_md5()] = [
		'type' => 'ct-condition',
		'condition' => [
			'trending_block_post_type' => $custom_post_type,
			'trending_block_post_source' => '!custom'
		],
		'options' => [
			$opt_id => [
				'type' => 'ct-select',
				'label' => $label,
				'value' => 'all_categories',
				'choices' => blocksy_ordered_keys($category_choices),
				'design' => 'inline',
				'sync' => [
					'selector' => '.ct-trending-block',
					'render' => function () {
						echo blc_get_trending_block();
					}
				],
			],
		]
	];

	$taxonomy_option_id = 'trending_block_show_' . $custom_post_type . '_taxonomy';
	$taxonomy_opt = [];

	if ($custom_post_type === 'product') {
		$taxonomies = array_values(array_diff(
			get_object_taxonomies($custom_post_type),
			[
				'product_type',
				'product_visibility',
				'product_shipping_class'
			]
		));

		foreach ($taxonomies as $single_taxonomy) {
			if ((strpos($single_taxonomy, 'pa_') === 0)) {
				continue;
			}

			$taxonomy_object = get_taxonomy($single_taxonomy);
			$taxonomy_opt[$single_taxonomy] = $taxonomy_object->label;

			if ($single_taxonomy === 'product_cat') {
				$taxonomy_opt[$single_taxonomy] = __('Category', 'blocksy-companion');
			}

			if ($single_taxonomy === 'product_tag') {
				$taxonomy_opt[$single_taxonomy] = __('Tag', 'blocksy-companion');
			}
		}
	} else {
		$taxonomy_opt = blocksy_get_taxonomies_for_cpt(
			$custom_post_type,
			['return_empty' => true]
		);
	}

	if (! empty($taxonomy_opt)) {
		$taxonomy_picker_options[blocksy_rand_md5()] = [
			'type' => 'ct-condition',
			'condition' => [
				'trending_block_post_type' => $custom_post_type,
				'trending_block_show_taxonomy' => 'yes',
				'trending_block_post_source' => '!custom'
			],
			'options' => [
				$taxonomy_option_id => [
					'type' => 'ct-select',
					'label' => __('Taxonomy Source', 'blocksy-companion'),
					'value' => $custom_post_type === 'product' ? 'product_cat' : array_keys($taxonomy_opt)[0],
					'choices' => blocksy_ordered_keys($taxonomy_opt),
					'design' => 'inline',
					'sync' => [
						'selector' => '.ct-trending-block',
						'render' => function () {
							echo blc_get_trending_block();
						}
					],
				]
			]
		];
	}
}

$options = [
	//  translators: This is a brand name. Preferably to not be translated
	'title' => _x('Trending Posts', 'Extension Brand Name', 'blocksy-companion'),
	'container' => [ 'priority' => 8 ],
	'options' => [
		'trending_posts_section_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => [
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Trending Posts', 'blocksy-companion' ),
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy-companion' ),
					'type' => 'tab',
					'options' => [
						[
							[
								'trending_block_label' => [
									'label' => __( 'Module Title', 'blocksy-companion' ),
									'type' => 'text',
									'design' => 'inline',
									'value' => __( 'Trending now', 'blocksy-companion' ),
									'sync' => 'live',
								],

								'trending_block_label_tag' => [
									'label' => __( 'Module Title Tag', 'blocksy-companion' ),
									'type' => 'ct-select',
									'value' => 'h3',
									'view' => 'text',
									'design' => 'inline',
									'choices' => blocksy_ordered_keys(
										[
											'h1' => 'H1',
											'h2' => 'H2',
											'h3' => 'H3',
											'h4' => 'H4',
											'h5' => 'H5',
											'h6' => 'H6',
											'p' => 'p',
											'span' => 'span',
										]
									),
									'sync' => [
										'selector' => '.ct-trending-block',
										'render' => function () {
											echo blc_get_trending_block();
										}
									]
								],
							],

							blc_site_has_feature()
								? [
									'trending_block_icon_source' => [
										'label' => __(
											'Module Title Icon Source',
											'blocksy-companion'
										),
										'type' => 'ct-radio',
										'value' => 'default',
										'view' => 'text',
										'design' => 'block',
										'divider' => 'top',
										'sync' => [
											'selector' => '.ct-trending-block',
											'render' => function () {
												echo blc_get_trending_block();
											}
										],
										'choices' => [
											'default' => __(
												'Default',
												'blocksy-companion'
											),
											'custom' => __(
												'Custom',
												'blocksy-companion'
											),
										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [
											'trending_block_icon_source' => 'custom',
										],
										'options' => [
											'trending_block_custom_icon' => [
												'type' => 'icon-picker',
												'label' => __(
													'Icon',
													'blocksy-companion'
												),
												'design' => 'inline',
												'divider' => 'top',
												'value' => [
													'icon' => 'fas fa-fire',
												],
												'sync' => [
													'selector' => '.ct-trending-block',
													'render' => function () {
														echo blc_get_trending_block();
													}
												]
											],
										],
									],
								]
								: [],

							'trending_block_post_type' => count($all_post_types) > 1 ? [
								'label' => __( 'Post Type', 'blocksy-companion' ),
								'type' => 'ct-select',
								'value' => 'post',
								'design' => 'inline',
								'divider' => 'top:full',
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => blocksy_ordered_keys($all_post_types),
								'sync' => [
									'selector' => '.ct-trending-block',
									'render' => function () {
										echo blc_get_trending_block();
									}
								],
							] : [
								'label' => __('Post Type', 'blocksy-companion'),
								'type' => 'hidden',
								'value' => 'post',
								'design' => 'none',
								'setting' => ['transport' => 'postMessage'],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [
									'trending_block_post_type' => 'product',
									'trending_block_post_source' => '!custom'
								],
								'options' => [
									'trending_block_product_type' => [
										'type' => 'ct-select',
										'label' => __('Products Status', 'blocksy-companion'),
										'value' => 'default',
										'choices' => blocksy_ordered_keys([
											'default' => __('Default', 'blocksy-companion'),
											'sale' => __('On Sale', 'blocksy-companion'),
											'rating' => __('Top Rated', 'blocksy-companion'),
											'best' => __('Best Sellers', 'blocksy-companion'),
										]),
										'design' => 'inline',
										'sync' => [
											'selector' => '.ct-trending-block',
											'render' => function () {
												echo blc_get_trending_block();
											}
										],
									]
								]
							],

							'trending_block_post_source' => [
								'type' => 'ct-select',
								'label' => __( 'Source', 'blocksy-companion' ),
								'value' => 'categories',
								'design' => 'inline',
								'choices' => blocksy_ordered_keys(
									[
										'categories' => __('Taxonomies', 'blocksy-companion'),
										'custom' => __( 'Custom Query', 'blocksy-companion' ),
									]
								),
								'sync' => [
									'selector' => '.ct-trending-block',
									'render' => function () {
										echo blc_get_trending_block();
									}
								],
							],
						],

						$cpt_options,

						[
							[
								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [
										'trending_block_post_source' => 'custom'
									],
									'options' => [

										'trending_block_post_id' => [
											'label' => __( 'Posts ID', 'blocksy-companion' ),
											'type' => 'text',
											'design' => 'inline',
											'desc' => blc_safe_sprintf(
												__('Separate posts ID by comma. How to find the %spost ID%s.', 'blocksy-companion'),
												'<a href="https://www.wpbeginner.com/beginners-guide/how-to-find-post-category-tag-comments-or-user-id-in-wordpress/" target="_blank">',
												'</a>'
											),
											'sync' => [
												'selector' => '.ct-trending-block',
												'render' => function () {
													echo blc_get_trending_block();
												}
											],
										],

									],
								],

								[
									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => ['trending_block_product_type' => '!sale'],
										'options' => [
											'trending_block_filter' => [
												'label' => __( 'Trending From', 'blocksy-companion' ),
												'type' => 'ct-select',
												'value' => 'all_time',
												'view' => 'text',
												'design' => 'inline',
												'setting' => [ 'transport' => 'postMessage' ],
												'choices' => blocksy_ordered_keys(
													[
														'all_time' => __( 'All Time', 'blocksy-companion' ),
														'last_24_hours' => __( 'Last 24 Hours', 'blocksy-companion' ),
														'last_7_days' => __( 'Last 7 Days', 'blocksy-companion' ),
														'last_month' => __( 'Last Month', 'blocksy-companion' ),
													]
												),

												'sync' => [
													'selector' => '.ct-trending-block',
													'render' => function () {
														echo blc_get_trending_block();
													}
												],
											],
										]
									]
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => ['trending_block_post_type' => 'product'],
									'options' => [
										'trending_block_show_price' => [
											'type'  => 'ct-switch',
											'label' => __( 'Show Product Price', 'blocksy-companion' ),
											'value' => 'no',
											'sync' => [
												'selector' => '.ct-trending-block',
												'render' => function () {
													echo blc_get_trending_block();
												}
											]
										],
									]
								],

								'trending_block_show_taxonomy' => [
									'type'  => 'ct-switch',
									'label' => __( 'Show Taxonomy', 'blocksy-companion' ),
									'value' => 'no',
									'sync' => [
										'selector' => '.ct-trending-block',
										'render' => function () {
											echo blc_get_trending_block();
										}
									]
								],
							],

							$taxonomy_picker_options,

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => ['trending_block_show_taxonomy' => 'yes'],
								'options' => [
									'trending_block_taxonomy_style' => [
										'label' => __( 'Taxonomy Style', 'blocksy-companion' ),
										'type' => 'ct-select',
										'value' => 'simple',
										'design' => 'inline',
										'view' => 'text',
										'choices' => blocksy_ordered_keys(
											[
												'simple' => __( 'Default', 'blocksy-companion' ),
												'pill' => __( 'Button', 'blocksy-companion' ),
												'underline' => __( 'Underline', 'blocksy-companion' ),
											]
										),
										'sync' => [
											'selector' => '.ct-trending-block',
											'loader_selector' => '.entry-meta',
											'render' => function () {
												echo blc_get_trending_block();
											}
										],
									],
								]
							],

							'trending_block_thumbnails_width' => [
								'label' => __( 'Image Width', 'blocksy-companion' ),
								'type' => 'ct-slider',
								'value' => 60,
								'min' => 10,
								'max' => 300,
								'defaultUnit' => 'px',
								'divider' => 'top:full',
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
							],

							'trending_block_thumbnails_size' => [
								'label' => __('Image Size', 'blocksy-companion'),
								'type' => 'ct-select',
								'value' => 'thumbnail',
								'view' => 'text',
								'design' => 'inline',
								// 'divider' => 'top',
								'choices' => blocksy_ordered_keys(
									blocksy_get_all_image_sizes()
								),
								'sync' => [
									'selector' => '.ct-trending-block',
									'render' => function () {
										echo blc_get_trending_block();
									}
								],
							],

							'trendingItemsVerticalAlignment' => [
								'type' => 'ct-radio',
								'label' => __( 'Vertical Alignment', 'blocksy-companion' ),
								'view' => 'text',
								'design' => 'block',
								'divider' => 'top:full',
								'responsive' => true,
								'attr' => [ 'data-type' => 'vertical-alignment' ],
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => 'center',
								'choices' => [
									'flex-start' => '',
									'center' => '',
									'flex-end' => '',
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							'trending_block_visibility' => [
								'label' => __( 'Visibility', 'blocksy-companion' ),
								'type' => 'ct-visibility',
								'design' => 'block',
								'sync' => 'live',

								'value' => blocksy_default_responsive_value([
									'desktop' => true,
									'tablet' => true,
									'mobile' => false,
								]),

								'choices' => blocksy_ordered_keys([
									'desktop' => __( 'Desktop', 'blocksy-companion' ),
									'tablet' => __( 'Tablet', 'blocksy-companion' ),
									'mobile' => __( 'Mobile', 'blocksy-companion' ),
								]),
							],
						],

						blc_site_has_feature() ? [
							'trending_block_location' => [
								'label' => __('Display Location', 'blocksy-companion'),
								'type' => 'ct-select',
								'design' => 'inline',
								'divider' => 'top',
								'value' => 'blocksy:content:bottom',
								'choices' => [
									[
										'key' => 'blocksy:content:bottom',
										'value' => __('Before Footer', 'blocksy-companion')
									],

									[
										'key' => 'blocksy:footer:after',
										'value' => __('After Footer', 'blocksy-companion')
									],

									[
										'key' => 'blocksy:header:after',
										'value' => __('After Header', 'blocksy-companion')
									]
								]
							],

							'trending_block_conditions' => [
								'label' => __('Display Conditions', 'blocksy-companion'),
								'type' => 'blocksy-display-condition',
								'divider' => 'top',
								'value' => [
									[
										'type' => 'include',
										'rule' => 'everywhere',
									]
								],
								'display' => 'modal',

								'modalTitle' => __('Trending Block Display Conditions', 'blocksy-companion'),
								'modalDescription' => __('Add one or more conditions to display the trending block.', 'blocksy-companion'),
								'design' => 'block',
								'sync' => 'live'
							],
						] : [],
					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy-companion' ),
					'type' => 'tab',
					'options' => [

						'trendingBlockHeadingFont' => [
							'type' => 'ct-typography',
							'label' => __( 'Module Title Font', 'blocksy-companion' ),
							'value' => blocksy_typography_default_values([
								'size' => '15px',
							]),
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'trendingBlockHeadingFontColor' => [
							'label' => __( 'Module Title Color', 'blocksy-companion' ),
							'type'  => 'ct-color-picker',
							'design' => 'block:right',
							'responsive' => true,
							'sync' => 'live',
							'divider' => 'bottom:full',
							'value' => [
								'default' => [
									'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy-companion' ),
									'id' => 'default',
									'inherit' => [
										'var(--theme-heading-1-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h1'
										],

										'var(--theme-heading-2-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h2'
										],

										'var(--theme-heading-3-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h3'
										],

										'var(--theme-heading-4-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h4'
										],

										'var(--theme-heading-5-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h5'
										],

										'var(--theme-heading-6-color, var(--theme-headings-color))' => [
											'trending_block_label_tag' => 'h6'
										],

										'var(--theme-text-color)' => [
											'trending_block_label_tag' => 'span|p'
										],
									]
								],
							],
						],

						'trendingBlockPostsFont' => [
							'type' => 'ct-typography',
							'label' => __( 'Posts Title Font', 'blocksy-companion' ),
							'value' => blocksy_typography_default_values([
								'size' => '15px',
								'variation' => 'n5',
							]),
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'trendingBlockFontColor' => [
							'label' => __( 'Posts Title Font Color', 'blocksy-companion' ),
							'type'  => 'ct-color-picker',
							'design' => 'block:right',
							'responsive' => true,
							'sync' => 'live',
							'value' => [
								'default' => [
									'color' => 'var(--theme-text-color)',
								],

								'hover' => [
									'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy-companion' ),
									'id' => 'default',
								],

								[
									'title' => __( 'Hover', 'blocksy-companion' ),
									'id' => 'hover',
									'inherit' => 'var(--theme-link-hover-color)'
								],
							],
						],


						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'trending_block_show_taxonomy' => 'yes' ],
							'options' => [

								'trendingBlockTaxonomyFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Taxonomy Font', 'blocksy-companion' ),
									'value' => blocksy_typography_default_values([
										'size' => '13px',
										'variation' => 'n5',
									]),
									'setting' => [ 'transport' => 'postMessage' ],
									'divider' => 'top:full'
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'trending_block_taxonomy_style' => '!pill' ],
									'options' => [

										'trending_categories_font_colors' => [
											'label' => __( 'Taxonomies Font Color', 'blocksy-companion' ),
											'type'  => 'ct-color-picker',
											'design' => 'block:right',
											'responsive' => true,
											'setting' => [ 'transport' => 'postMessage' ],

											'value' => [
												'default' => [
													'color' => 'var(--theme-text-color)',
												],

												'hover' => [
													'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
												],
											],

											'pickers' => [
												[
													'title' => __( 'Initial', 'blocksy-companion' ),
													'id' => 'default',
												],

												[
													'title' => __( 'Hover', 'blocksy-companion' ),
													'id' => 'hover',
													'inherit' => 'var(--theme-link-hover-color)'
												],
											],
										],

									],
								],


								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'trending_block_taxonomy_style' => 'pill' ],
									'options' => [

										'trending_categories_button_type_font_colors' => [
											'label' => __( 'Taxonomies Font Color', 'blocksy-companion' ),
											'type'  => 'ct-color-picker',
											'design' => 'block:right',
											'responsive' => true,
											'noColor' => [ 'background' => 'var(--theme-text-color)'],
											'sync' => 'live',
											'value' => [
												'default' => [
													'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
												],

												'hover' => [
													'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
												],
											],

											'pickers' => [
												[
													'title' => __( 'Initial', 'blocksy-companion' ),
													'id' => 'default',
													'inherit' => 'var(--theme-button-text-initial-color)'
												],

												[
													'title' => __( 'Hover', 'blocksy-companion' ),
													'id' => 'hover',
													'inherit' => 'var(--theme-button-text-hover-color)'
												],
											],
										],

										'trending_categories_button_type_background_colors' => [
											'label' => __( 'Taxonomies Button Color', 'blocksy-companion' ),
											'type'  => 'ct-color-picker',
											'design' => 'block:right',
											'responsive' => true,
											'noColor' => [ 'background' => 'var(--theme-text-color)'],
											'sync' => 'live',
											'value' => [
												'default' => [
													'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
												],

												'hover' => [
													'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
												],
											],

											'pickers' => [
												[
													'title' => __( 'Initial', 'blocksy-companion' ),
													'id' => 'default',
													'inherit' => 'var(--theme-button-background-initial-color)'
												],

												[
													'title' => __( 'Hover', 'blocksy-companion' ),
													'id' => 'hover',
													'inherit' => 'var(--theme-button-background-hover-color)'
												],
											],
										],

									],
								],

							],
						],


						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => ['trending_block_post_type' => 'product'],
							'options' => [

								'trendingBlockPriceFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Taxonomy Font', 'blocksy-companion' ),
									'value' => blocksy_typography_default_values([
										'size' => '13px',
										// 'variation' => 'n5',
									]),
									'setting' => [ 'transport' => 'postMessage' ],
									'divider' => 'top:full'
								],

								'trendingBlockPriceFontColor' => [
									'label' => __( 'Taxonomy Font Color', 'blocksy-companion' ),
									'type'  => 'ct-color-picker',
									'design' => 'block:right',
									'responsive' => true,
									'sync' => 'live',
									'value' => [
										'default' => [
											'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy-companion' ),
											'id' => 'default',
											'inherit' => 'var(--theme-text-color)'
										],
									],
								],

							],
						],


						'trendingBlockImageRadius' => [
							'label' => __( 'Image Border Radius', 'blocksy-companion' ),
							'type' => 'ct-spacing',
							'divider' => 'top:full',
							'value' => blocksy_spacing_value(),
							'inputAttr' => [
								'placeholder' => '100'
							],
							'min' => 0,
							'sync' => 'live',
						],

						'trendingBlockArrowsColor' => [
							'label' => __( 'Arrows Color', 'blocksy-companion' ),
							'type'  => 'ct-color-picker',
							'design' => 'block:right',
							'responsive' => true,
							'divider' => 'top:full',
							'sync' => 'live',
							'value' => [
								'default' => [
									'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
								],

								'hover' => [
									'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy-companion' ),
									'id' => 'default',
									'inherit' => 'var(--theme-text-color)'
								],

								[
									'title' => __( 'Hover', 'blocksy-companion' ),
									'id' => 'hover',
									'inherit' => 'var(--theme-link-hover-color)'
								],
							],
						],

						'trending_block_background' => [
							'label' => __( 'Container Background', 'blocksy-companion' ),
							'type' => 'ct-background',
							'design' => 'block:right',
							'responsive' => true,
							'divider' => 'top',
							'sync' => 'live',
							'value' => blocksy_background_default_value([
								'backgroundColor' => [
									'default' => [
										'color' => 'var(--theme-palette-color-5)',
									],
								],
							])
						],

						'trendingBlockContainerSpacing' => [
							'label' => __( 'Container Inner Spacing', 'blocksy-companion' ),
							'type' => 'ct-slider',
							'divider' => 'top',
							'value' => '30px',
							'units' => blocksy_units_config([
								[
									'unit' => 'px',
									'min' => 0,
									'max' => 100,
								],
							]),
							'responsive' => true,
							'sync' => 'live',
						],

					],
				],
			]
		]
	]
];
