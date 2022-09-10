<?php
/**
 * Retrieve (template and preset) local library functionality.
 *
 * @package Builder.
 */

/**
 * Get Library Item items.
 *
 * Item refers to any cloud item, preset for example.
 * Item Items refers to any cloud item's items. Preset's items are templates.
 *
 * @since ??
 *
 * @param string $item_type Item type.
 * @param int    $item_id Item Id.
 *
 * @return array
 */
function et_theme_builder_library_get_item_items( $item_type, $item_id ) {
	if ( ! in_array( $item_type, array( 'set', 'template' ), true ) ) {
		return;
	}

	$items    = array();
	$callback = "et_theme_builder_library_get_{$item_type}_items_data";

	if ( is_callable( $callback ) ) {
		$items = $callback( $item_id );
	}

	return $items;
}

/**
 * Get theme builder library item `use on` or `exclude from` data.
 *
 * @since ??
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key (_et_use_on OR _et_exclude_from).
 * @param array  $meta_values Meta Values.
 *
 * @return array
 */
function et_theme_builder_library_get_item_use_or_exclude_data( $post_id, $key, $meta_values = [] ) {
	$data             = array();
	$template_options = array();
	if ( 0 < $post_id && empty( $meta_values ) ) {
		$meta_values = get_post_meta( $post_id, $key ) ? get_post_meta( $post_id, $key ) : array();
	}

	// Flatten the template settings options.
	foreach ( et_theme_builder_get_template_settings_options() as $options ) {
		foreach ( $options['settings'] as $settings ) {
			array_push( $template_options, $settings );
		}
	}

	// Prepare `Use On` OR `Exclude From` label.
	foreach ( $meta_values as $template_id ) {
		foreach ( $template_options as $option ) {
			if ( $template_id === $option['id'] ) {
				array_push( $data, $option['label'] );
			}
		}
	}

	return array_unique( $data );
}

/**
 * Processes item taxonomies for inclusion in the theme builder library UI items data.
 *
 * @since ??
 *
 * @param WP_POST $post          Unprocessed item.
 * @param object  $item          Currently processing item.
 * @param int     $index         The item's index position.
 * @param array[] $item_terms    Processed items.
 * @param string  $taxonomy_name Item name.
 * @param string  $type          Item type.
 *
 * @return void
 */
function et_theme_builder_library_process_item_taxonomy( $post, $item, $index, &$item_terms, $taxonomy_name, $type ) {
	$terms = wp_get_post_terms( $post->ID, $taxonomy_name );

	if ( ! $terms ) {
		if ( 'category' === $type ) {
			$item->category_slug = 'uncategorized';
		}

		return;
	}

	foreach ( $terms as $term ) {
		$term_name = et_core_intentionally_unescaped( $term->name, 'react_jsx' );

		if ( ! isset( $item_terms[ $term->term_id ] ) ) {
			$item_terms[ $term->term_id ] = array(
				'id'    => $term->term_id,
				'name'  => $term_name,
				'slug'  => $term->slug,
				'items' => array(),
			);
		}

		$item_terms[ $term->term_id ]['items'][] = $index;

		if ( 'category' === $type ) {
			$item->categories[] = $term_name;
		} else {
			$item->tags[] = $term_name;
		}

		$item->{$type . '_ids'}[] = $term->term_id;

		if ( ! isset( $item->{$type . '_slug'} ) ) {
			$item->{$type . '_slug'} = $term->slug;
		}

		$id = get_post_meta( $post->ID, "_primary_{$taxonomy_name}", true );

		if ( $id ) {
			// $id is a string, $term->term_id is an int.
			if ( $id === $term->term_id ) {
				// This is the primary term (used in the item URL).
				$item->{$type . '_slug'} = $term->slug;
			}
		}
	}
}

/**
 * Gets the terms list and processes it into desired format.
 *
 * @since ??
 *
 * @param string $term_name Term Name.
 *
 * @return array $terms_by_id
 */
function et_theme_builder_library_get_processed_terms( $term_name ) {
	$terms       = get_terms( $term_name, array( 'hide_empty' => false ) );
	$terms_by_id = array();

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	foreach ( $terms as $term ) {
		$term_id = $term->term_id;

		$terms_by_id[ $term_id ]['id']    = $term_id;
		$terms_by_id[ $term_id ]['name']  = $term->name;
		$terms_by_id[ $term_id ]['slug']  = $term->slug;
		$terms_by_id[ $term_id ]['count'] = $term->count;
	}

	return $terms_by_id;
}

/**
 * Get item description.
 *
 * @since ??
 *
 * @param integer $post_id             Post ID.
 * @param boolean $is_default_template Whether it is default template or not.
 *
 * @return mixed $output
 */
function et_theme_builder_library_get_item_description( $post_id, $is_default_template ) {
	if ( $is_default_template ) {
		$item_desc = et_core_intentionally_unescaped( ET_Builder_TBItem_Library::__( 'Default Website Template' ), 'react_jsx' );

		return '<span class="et-cloud-app-layout-desc-item-global">' . $item_desc . '</span>';
	}

	$output       = '';
	$use_on       = et_theme_builder_library_get_item_use_or_exclude_data( $post_id, '_et_use_on' );
	$exclude_from = et_theme_builder_library_get_item_use_or_exclude_data( $post_id, '_et_exclude_from' );

	if ( empty( $use_on ) && empty( $exclude_from ) ) {
		return $output;
	}

	if ( ! empty( $use_on ) ) {
		$output .= '
			<li class="et-cloud-app-layout-desc__use-on-label">
				' . et_core_intentionally_unescaped( ET_Builder_TBItem_Library::__( 'Use On' ), 'react_jsx' ) . '
			</li>
			<ul class="et-cloud-app-layout-desc__inner_list">
				<li>' . join( ',</li><li>', $use_on ) . '</li>
			</ul>
		';
	}

	if ( ! empty( $exclude_from ) ) {
		$output .= '
			<li class="et-cloud-app-layout-desc__exclude-from-label">
				' . et_core_intentionally_unescaped( ET_Builder_TBItem_Library::__( 'Exclude From' ), 'react_jsx' ) . '
			</li>
			<ul class="et-cloud-app-layout-desc__inner_list">
				<li>' . join( ',</li><li>', $exclude_from ) . '</li>
			</ul>
		';
	}

	return '<ul class="et-cloud-app-layout-desc">' . $output . '</ul>';
}

/**
 * Get item description.
 *
 * @since ??
 *
 * @param array $template Payload Template data.
 *
 * @return string $output
 */
function et_theme_builder_library_get_item_description_from_payload( $template ) {
	$_                   = et_();
	$is_default_template = '1' === $_->array_get( $template, 'default', '0' );

	if ( $is_default_template ) {
		$item_desc = esc_html( ET_Builder_TBItem_Library::__( 'Default Website Template' ) );

		return '<span class="et-cloud-app-layout-desc-item-global">' . $item_desc . '</span>';
	}

	$output       = '';
	$use_on       = et_theme_builder_library_get_item_use_or_exclude_data( 0, '_et_use_on', $_->array_get( $template, 'use_on', [] ) );
	$exclude_from = et_theme_builder_library_get_item_use_or_exclude_data( 0, '_et_exclude_from', $_->array_get( $template, 'exclude_from', [] ) );

	if ( empty( $use_on ) && empty( $exclude_from ) ) {
		return $output;
	}

	if ( ! empty( $use_on ) ) {
		$output .= '
			<li class="et-cloud-app-layout-desc__use-on-label">
				' . esc_html( ET_Builder_TBItem_Library::__( 'Use On' ) ) . '
			</li>
			<ul class="et-cloud-app-layout-desc__inner_list">
				<li>' . join( ',</li><li>', $use_on ) . '</li>
			</ul>
		';
	}

	if ( ! empty( $exclude_from ) ) {
		$output .= '
			<li class="et-cloud-app-layout-desc__exclude-from-label">
				' . esc_html( ET_Builder_TBItem_Library::__( 'Exclude From' ) ) . '
			</li>
			<ul class="et-cloud-app-layout-desc__inner_list">
				<li>' . join( ',</li><li>', $exclude_from ) . '</li>
			</ul>
		';
	}

	return '<ul class="et-cloud-app-layout-desc">' . $output . '</ul>';
}

/**
 * Generates items data for the theme builder's library UI.
 *
 * @param string $item_type Item type.
 *
 * @since ??
 *
 * @return array $data
 */
function et_theme_builder_library_get_library_items_data( $item_type ) {
	$_                  = ET_Core_Data_Utils::instance();
	$tb_items           = ET_Builder_Post_Type_TBItem::instance();
	$tb_item_tags       = ET_Builder_Post_Taxonomy_LayoutTag::instance();
	$tb_item_categories = ET_Builder_Post_Taxonomy_LayoutCategory::instance();
	$tb_item_types      = ET_Builder_Post_Taxonomy_TBItemType::instance();

	$item_categories = array();
	$item_tags       = array();
	$item_types      = array();
	$items           = array();
	$index           = 0;

	$set_template_flag = '1';

	$posts = $tb_items
		->query()
		->not()->with_meta( '_et_set_template', $set_template_flag )
		->run( array( 'post_status' => array( 'publish', 'trash' ) ) );

	$posts = $_->array_sort_by( is_array( $posts ) ? $posts : array( $posts ), 'post_name' );

	foreach ( $posts as $post ) {
		$item = new stdClass();

		setup_postdata( $post );

		$item->id    = $post->ID;
		$item->index = $index;
		$item->date  = $post->post_date;
		$types       = wp_get_post_terms( $item->id, $tb_item_types->name );

		if ( ! $types ) {
			continue;
		}

		$item->type = $types[0]->slug;

		if ( $item_type !== $item->type ) {
			continue;
		}

		$title = html_entity_decode( $post->post_title );

		if ( $title ) {
			// Remove periods since we use dot notation to retrieve translation.
			str_replace( '.', '', $title );

			$item->name = et_core_intentionally_unescaped( $title, 'react_jsx' );
		}

		$item->slug = $post->post_name;
		$item->url  = esc_url( wp_make_link_relative( get_permalink( $post ) ) );

		$item->short_name   = '';
		$item->is_default   = get_post_meta( $item->id, '_et_default', true );
		$item->description  = et_theme_builder_library_get_item_description( $item->id, $item->is_default );
		$item->is_favorite  = $tb_items->is_favorite( $item->id );
		$item->isTrash      = 'trash' === $post->post_status; // phpcs:ignore ET.Sniffs.ValidVariableName.UsedPropertyNotSnakeCase -- This is valid format for the property in the Cloud App.
		$item->categories   = array();
		$item->category_ids = array();
		$item->tags         = array();
		$item->tag_ids      = array();

		et_theme_builder_library_process_item_taxonomy(
			$post,
			$item,
			$index,
			$item_categories,
			$tb_item_categories->name,
			'category'
		);
		et_theme_builder_library_process_item_taxonomy(
			$post,
			$item,
			$index,
			$item_tags,
			$tb_item_tags->name,
			'tag'
		);

		$item->item_items = et_theme_builder_library_get_item_items( $item_type, $post->ID );

		wp_reset_postdata();

		$items[] = $item;

		$index++;
	}

	return array(
		'categories' => et_theme_builder_library_get_processed_terms( $tb_item_categories->name ),
		'tags'       => et_theme_builder_library_get_processed_terms( $tb_item_tags->name ),
		'items'      => $items,
	);
}


/**
 * Get all terms of an item and merge any newly passed IDs with the list.
 *
 * @since ??
 *
 * @param string $new_terms_list List of new terms.
 * @param array  $taxonomies Taxonomies.
 * @param string $taxonomy_name Taxonomy name.
 *
 * @return array
 */
function et_theme_builder_library_get_all_item_terms( $new_terms_list, $taxonomies, $taxonomy_name ) {
	$new_names_array = explode( ',', $new_terms_list );

	foreach ( $new_names_array as $new_name ) {
		if ( '' !== $new_name ) {
			$new_term = wp_insert_term( $new_name, $taxonomy_name );

			if ( ! is_wp_error( $new_term ) ) {
				$taxonomies[] = $new_term['term_id'];
			} elseif (
					! empty( $new_term->error_data ) &&
					! empty( $new_term->error_data['term_exists'] )
				) {
				$taxonomies[] = $new_term->error_data['term_exists'];
			}
		}
	}

	return $taxonomies;
}

/**
 * Insert the theme builder library item duplication post.
 *
 * @since ??
 *
 * @param string $title      Title.
 * @param string $content    Content.
 * @param array  $tax_input  Taxonomy.
 * @param array  $meta_input Meta.
 *
 * @return int ID
 */
function et_theme_builder_library_insert_post( $title, $content, $tax_input = array(), $meta_input = array() ) {
	$tb_items = ET_Builder_Post_Type_TBItem::instance();
	$item     = array(
		'post_title'   => $title,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => $tb_items->name,
		'tax_input'    => $tax_input,
		'meta_input'   => $meta_input,
	);

	return wp_insert_post( $item );
}

/**
 * Update the theme builder library item. Following updates supported:
 * - Delete
 * - Delete Permanently
 * - Restore
 * - Rename
 * - Edit Categories/Tags
 * - Toggle Favorite status
 * - Duplicate
 *
 * @since ??
 *
 * @param array $payload Array with the update details.
 *
 * @return array Updated item details
 */
function et_theme_builder_library_update_item_data( $payload ) {
	$update_details = isset( $payload['update_details'] ) ? $payload['update_details'] : array();

	if (
		empty( $update_details['updateType'] ) ||
		empty( $update_details['itemType'] )
	) {
		return false;
	}

	$_                  = ET_Core_Data_Utils::instance();
	$tb_items           = ET_Builder_Post_Type_TBItem::instance();
	$tb_item_types      = ET_Builder_Post_Taxonomy_TBItemType::instance();
	$tb_item_tags       = ET_Builder_Post_Taxonomy_LayoutTag::instance();
	$tb_item_categories = ET_Builder_Post_Taxonomy_LayoutCategory::instance();

	$update_details  = $payload['update_details'];
	$update_type     = $update_details['updateType'];
	$item_type       = $update_details['itemType'];
	$item_id         = intval( $payload['item_id'] );
	$categories      = empty( $update_details['itemCategories'] ) ? [] : array_unique( array_map( 'intval', $update_details['itemCategories'] ) );
	$tags            = empty( $update_details['itemTags'] ) ? [] : array_unique( array_map( 'intval', $update_details['itemTags'] ) );
	$favorite_status = 'on' === sanitize_text_field( $update_details['favoriteStatus'] ) ? 'favorite' : '';
	$item_update     = array( 'ID' => $item_id );
	$new_id          = '';
	$type_template   = ET_THEME_BUILDER_ITEM_TEMPLATE === $item_type;
	$type_set        = ET_THEME_BUILDER_ITEM_SET === $item_type;

	switch ( $update_type ) {
		case 'delete':
			if ( ET_THEME_BUILDER_ITEM_SET === $item_type ) {
				$templates = get_post_meta( $item_id, '_et_template_id', false );

				foreach ( $templates as $template ) {
					$template_id = is_string( $template ) ? absint( $template ) : 0;

					wp_trash_post( $template_id );
				}
			}

			wp_trash_post( $item_id );
			break;
		case 'delete_permanently':
			if ( ET_THEME_BUILDER_ITEM_SET === $item_type ) {
				$templates = get_post_meta( $item_id, '_et_template_id', false );

				foreach ( $templates as $template ) {
					$template_id = is_string( $template ) ? absint( $template ) : 0;

					wp_delete_post( $template_id, true );
				}
			}

			wp_delete_post( $item_id, true );
			break;
		case 'restore':
			// wp_untrash_post() restores the post to `draft` by default, we have to set `publish` status via filter.
			add_filter(
				'wp_untrash_post_status',
				function() {
					return 'publish';
				}
			);
			wp_untrash_post( $item_id );
			remove_filter(
				'wp_untrash_post_status',
				function() {
					return 'publish';
				}
			);
			break;
		case 'rename':
			$item_update['post_title'] = sanitize_text_field( $update_details['itemName'] );
			wp_update_post( $item_update );
			break;
		case 'edit_cats':
			wp_set_object_terms( $item_id, $categories, $tb_item_categories->name );
			wp_set_object_terms( $item_id, $tags, $tb_item_tags->name );
			break;
		case 'toggle_fav':
			update_post_meta( $item_id, 'favorite_status', $favorite_status );
			break;
		case 'duplicate':
		case 'duplicate_and_delete':
			if ( ! empty( $update_details['newCategoryName'] ) ) {
				$categories = et_theme_builder_library_get_all_item_terms(
					$update_details['newCategoryName'],
					$categories,
					$tb_item_categories->name
				);
			}

			if ( ! empty( $update_details['newTagName'] ) ) {
				$tags = et_theme_builder_library_get_all_item_terms(
					$update_details['newTagName'],
					$tags,
					$tb_item_tags->name
				);
			}

			$title              = sanitize_text_field( $update_details['itemName'] );
			$meta_input         = array( 'favorite_status' => $favorite_status );
			$content_details    = $_->array_get( $update_details, 'content', null );
			$is_item_from_cloud = isset( $content_details );
			$tax_input          = array(
				$tb_item_categories->name => $categories,
				$tb_item_tags->name       => $tags,
				$tb_item_types->name      => $item_type,
			);

			if ( $is_item_from_cloud ) {
				$meta_input['_et_has_default_template'] = (int) filter_var( $content_details['has_default_template'], FILTER_VALIDATE_BOOLEAN );
				$meta_input['_et_has_global_layouts']   = (int) filter_var( $content_details['has_global_layouts'], FILTER_VALIDATE_BOOLEAN );

				if ( $type_set ) {
					$set_id     = et_theme_builder_library_insert_post( $title, '', $tax_input, $meta_input );
					$meta_input = array(); // Reset.
				}

				$templates = $_->array_get( $content_details, 'templates', array() );

				foreach ( $templates as $template ) :
					/**
					 * $layouts_reference: content -> templates -> layouts
					 * $layouts_detail:    content -> layouts
					 */
					$layouts_reference = $_->array_get( $template, 'layouts', array() );
					$layouts_detail    = $_->array_get( $content_details, 'layouts', array() );
					$full_layout       = array();

					$meta_input['_et_template_title'] = sanitize_text_field( $_->array_get( $template, 'title', '' ) );

					$use_on       = array_map( 'sanitize_text_field', $_->array_get( $template, 'use_on', array() ) );
					$exclude_from = array_map( 'sanitize_text_field', $_->array_get( $template, 'exclude_from', array() ) );

					$meta_input['_et_autogenerated_title'] = (int) filter_var( $template['autogenerated_title'], FILTER_VALIDATE_BOOLEAN );
					$meta_input['_et_default']             = (int) filter_var( $template['default'], FILTER_VALIDATE_BOOLEAN );
					$meta_input['_et_enabled']             = (int) filter_var( $template['enabled'], FILTER_VALIDATE_BOOLEAN );

					if ( isset( $layouts_reference['header'] ) ) {
						$layout_id  = (int) $layouts_reference['header']['id'];
						$is_enabled = $layouts_reference['header']['enabled'];

						$meta_input['_et_header_layout_enabled'] = (int) filter_var( $is_enabled, FILTER_VALIDATE_BOOLEAN );

						if ( $layout_id ) {
							$is_global = $layouts_detail[ $layout_id ]['theme_builder']['is_global'];

							$full_layout['header']['post_content']   = wp_unslash( $layouts_detail[ $layout_id ]['data'][ $layout_id ] );
							$meta_input['_et_header_layout_global']  = (int) filter_var( $is_global, FILTER_VALIDATE_BOOLEAN );
						}
					} else {
						// if area is empty and is not explicitly disabled save it as enabled.
						$meta_input['_et_header_layout_enabled'] = 1;
					}

					if ( isset( $layouts_reference['body'] ) ) {
						$layout_id  = (int) $layouts_reference['body']['id'];
						$is_enabled = $layouts_reference['body']['enabled'];

						$meta_input['_et_body_layout_enabled'] = (int) filter_var( $is_enabled, FILTER_VALIDATE_BOOLEAN );

						if ( $layout_id ) {
							$is_global = $layouts_detail[ $layout_id ]['theme_builder']['is_global'];

							$full_layout['body']['post_content']   = wp_unslash( $layouts_detail[ $layout_id ]['data'][ $layout_id ] );
							$meta_input['_et_body_layout_global']  = (int) filter_var( $is_global, FILTER_VALIDATE_BOOLEAN );
						}
					} else {
						// if area is empty and is not explicitly disabled save it as enabled.
						$meta_input['_et_body_layout_enabled'] = 1;
					}

					if ( isset( $layouts_reference['footer'] ) ) {
						$layout_id  = (int) $layouts_reference['footer']['id'];
						$is_enabled = $layouts_reference['footer']['enabled'];

						$meta_input['_et_footer_layout_enabled'] = (int) filter_var( $is_enabled, FILTER_VALIDATE_BOOLEAN );

						if ( $layout_id ) {
							$is_global = $layouts_detail[ $layout_id ]['theme_builder']['is_global'];

							$full_layout['footer']['post_content']   = wp_unslash( $layouts_detail[ $layout_id ]['data'][ $layout_id ] );
							$meta_input['_et_footer_layout_global']  = (int) filter_var( $is_global, FILTER_VALIDATE_BOOLEAN );
						}
					} else {
						// if area is empty and is not explicitly disabled save it as enabled.
						$meta_input['_et_footer_layout_enabled'] = 1;
					}

					$title   = $type_set ? $meta_input['_et_template_title'] : $title;
					$content = wp_json_encode( $full_layout );
					$new_id  = et_theme_builder_library_insert_post( $title, wp_slash( $content ), $tax_input, $meta_input );

					foreach ( $use_on as $condition ) {
						add_post_meta( $new_id, '_et_use_on', sanitize_text_field( $condition ) );
					}

					foreach ( $exclude_from as $condition ) {
						add_post_meta( $new_id, '_et_exclude_from', sanitize_text_field( $condition ) );
					}

					if ( $type_set ) {
						add_post_meta( $new_id, '_et_set_template', 1 );
						add_post_meta( $set_id, '_et_template_id', $new_id );

						if ( $meta_input['_et_default'] ) {
							add_post_meta( $set_id, '_et_default_template_id', $new_id );
						}
					}

				endforeach;
			} else {
				/**
				 * For local item duplication.
				 */
				if ( $type_template ) {
					$meta_input = array_merge(
						$meta_input,
						et_theme_builder_get_template_settings( $item_id, false )
					);

					$use_on       = $meta_input['_et_use_on'];
					$exclude_from = $meta_input['_et_exclude_from'];

					// Remove from post meta insertion.
					unset( $meta_input['_et_use_on'], $meta_input['_et_exclude_from'] );
				} else {
					$meta_keys = array(
						'_et_has_global_layouts',
						'_et_has_default_template',
					);

					foreach ( $meta_keys as $key ) {
						$meta_input[ $key ] = get_post_meta( $item_id, $key, true );
					}
				}

				$content = get_the_content( null, false, $item_id );
				$new_id  = et_theme_builder_library_insert_post( $title, wp_slash( $content ), $tax_input, $meta_input );

				if ( $type_template ) {
					foreach ( $use_on as $condition ) {
						add_post_meta( $new_id, '_et_use_on', sanitize_text_field( $condition ) );
					}

					foreach ( $exclude_from as $condition ) {
						add_post_meta( $new_id, '_et_exclude_from', sanitize_text_field( $condition ) );
					}
				} else {
					$template_ids = get_post_meta( $item_id, '_et_template_id', false );
					$template_map = [];

					foreach ( $template_ids as $maybe_template_id ) {
						$template_id  = absint( $maybe_template_id );
						$library_item = new ET_Theme_Builder_Local_Library_Item( $template_id );

						$duplicated_template_id       = $library_item->duplicate_item();
						$template_map[ $template_id ] = $duplicated_template_id;
					}

					$maybe_default_template_id = get_post_meta( $item_id, '_et_default_template_id', true );
					$default_template_id       = absint( $maybe_default_template_id );

					if ( 0 !== $default_template_id ) {
						$duplicated_default_template_id = $template_map[ $default_template_id ];
						update_post_meta( $new_id, '_et_default_template_id', $duplicated_default_template_id );
					}

					foreach ( $template_map as $duplicated_template_id ) {
						add_post_meta( $new_id, '_et_template_id', $duplicated_template_id );
					}
				}
			}
			break;
	}

	$processed_new_tags = array();
	$processed_new_cats = array();

	$updated_tags = get_terms(
		array(
			'taxonomy'   => $tb_item_tags->name,
			'hide_empty' => false,
		)
	);

	$updated_categories = get_terms(
		array(
			'taxonomy'   => $tb_item_categories->name,
			'hide_empty' => false,
		)
	);

	if ( ! empty( $updated_tags ) ) {
		foreach ( $updated_tags as $single_tag ) {
			$processed_new_tags[] = array(
				'name'     => $single_tag->name,
				'id'       => $single_tag->term_id,
				'count'    => $single_tag->count,
				'location' => 'local',
			);
		}
	}

	if ( ! empty( $updated_categories ) ) {
		foreach ( $updated_categories as $single_category ) {
			$processed_new_cats[] = array(
				'name'     => $single_category->name,
				'id'       => $single_category->term_id,
				'count'    => $single_category->count,
				'location' => 'local',
			);
		}
	}

	$new_item_id = isset( $set_id ) ? $set_id : $new_id;

	return array(
		'updatedItem'  => $item_id,
		'newItem'      => $new_item_id,
		'updateType'   => $update_type,
		'categories'   => $categories,
		'tags'         => $tags,
		'updatedTerms' => array(
			'categories' => $processed_new_cats,
			'tags'       => $processed_new_tags,
		),
	);
}

/**
 * Get the theme builder library temporary item info.
 *
 * @since ??
 *
 * @param array  $template       Template.
 * @param string $layout_type    Layout type.
 * @param array  $post_content   Post content.
 * @param array  $global_layouts Global layouts.
 * @param array  $layouts_info   Layout info.
 * @param bool   $is_cloud_item  Is cloud item or not.
 * @param int    $id             ID (optional).
 *
 * @return array
 */
function et_theme_builder_library_get_temp_item_info( $template, $layout_type, $post_content, $global_layouts, $layouts_info, $is_cloud_item, $id = null ) {
	if ( $is_cloud_item ) {
		$layout_id  = (int) $layouts_info[ $layout_type ]['id'];
		$is_enabled = (int) filter_var( $layouts_info[ $layout_type ]['enabled'], FILTER_VALIDATE_BOOLEAN );
		$is_global  = $template[ $layout_type . '_layout_global' ];
		$content    = $post_content[ $layout_id ]['data'][ $layout_id ];
	} else {
		$is_enabled = get_post_meta( $id, '_et_' . $layout_type . '_layout_enabled', true );
		$is_global  = get_post_meta( $id, '_et_' . $layout_type . '_layout_global', true );
		$content    = $post_content->post_content;
	}

	if ( $is_global && isset( $global_layouts[ $layout_type ] ) ) {
		$layout_id = $global_layouts[ $layout_type ];
	} else {
		$layout_id = wp_insert_post(
			array(
				'post_content' => $content,
				'post_type'    => et_theme_builder_get_valid_layout_post_type( $layout_type ),
			)
		);
	}

	return array(
		'id'      => $layout_id,
		'enabled' => $is_enabled,
	);
}

/**
 * Save the theme builder library temporary cloud item.
 *
 * @since ??
 *
 * @param array $template_info  Template info.
 * @param array $layouts_detail Template layouts.
 * @param array $global_layouts Global layouts.
 *
 * @return array
 */
function et_theme_builder_library_save_temp_cloud_layout_data( $template_info, $layouts_detail, $global_layouts = array() ) {
	$template      = array();
	$layouts_info  = et_()->array_get( $template_info, 'layouts', array() );
	$layout_types  = array( 'header', 'body', 'footer' );
	$is_cloud_item = true;

	$is_default    = et_()->array_get( $template_info, 'default', false );
	$is_enabled    = et_()->array_get( $template_info, 'enabled', false );
	$is_auto_title = et_()->array_get( $template_info, 'autogenerated_title', false );

	$template['default']             = (int) filter_var( $is_default, FILTER_VALIDATE_BOOLEAN );
	$template['enabled']             = (int) filter_var( $is_enabled, FILTER_VALIDATE_BOOLEAN );
	$template['autogenerated_title'] = (int) filter_var( $is_auto_title, FILTER_VALIDATE_BOOLEAN );

	foreach ( $layout_types as $layout_type ) {
		if ( ! isset( $layouts_info[ $layout_type ] ) ) {
			continue;
		}

		$layout_id = $layouts_info[ $layout_type ]['id'];

		if ( empty( $layout_id ) ) {
			continue;
		}

		$is_global = $layouts_detail[ $layout_id ]['theme_builder']['is_global'];

		$template[ $layout_type . '_layout_global' ] = (int) filter_var( $is_global, FILTER_VALIDATE_BOOLEAN );

		$template['layouts'][ $layout_type ] = et_theme_builder_library_get_temp_item_info(
			$template,
			$layout_type,
			$layouts_detail,
			$global_layouts,
			$layouts_info,
			$is_cloud_item
		);
	}

	return $template;
}

/**
 * Save the theme builder library temporary item.
 *
 * @since ??
 *
 * @param integer $id      Template ID.
 * @param object  $content Template content.
 * @param array   $global_layouts Global Layouts.
 *
 * @return array
 */
function et_theme_builder_library_save_temp_local_layout_data( $id, $content, $global_layouts = array() ) {
	$template      = array();
	$layout_types  = array( 'header', 'body', 'footer' );
	$is_cloud_item = false;

	$template['default']      = get_post_meta( $id, '_et_default', true );
	$template['use_on']       = get_post_meta( $id, '_et_use_on' );
	$template['exclude_from'] = get_post_meta( $id, '_et_exclude_from' );

	foreach ( $layout_types as $layout_type ) {
		if ( ! isset( $content->{$layout_type} ) ) {
			continue;
		}

		$template['layouts'][ $layout_type ] = et_theme_builder_library_get_temp_item_info(
			$template,
			$layout_type,
			$content->{$layout_type},
			$global_layouts,
			$content,
			$is_cloud_item,
			$id
		);
	}

	return $template;
}

/**
 * Remove the theme builder library temporary item.
 *
 * @since ??
 *
 * @param array $data Template Ids.
 *
 * @return void
 */
function et_theme_builder_library_remove_temp_layout_data( $data ) {
	if ( isset( $data['layouts']['header'] ) ) {
		wp_delete_post( $data['layouts']['header']['id'], true );
	}

	if ( isset( $data['layouts']['body'] ) ) {
		wp_delete_post( $data['layouts']['body']['id'], true );
	}

	if ( isset( $data['layouts']['footer'] ) ) {
		wp_delete_post( $data['layouts']['footer']['id'], true );
	}
}

/**
 * Get the theme builder library exported content.
 *
 * @since ??
 *
 * @param array $ids Items Id.
 *
 * @return array
 */
function et_theme_builder_library_get_exported_content( $ids ) {
	$context     = 'et_theme_builder';
	$portability = et_core_portability_load( $context );
	$result      = array(
		'context'   => $context,
		'templates' => array(),
		'layouts'   => array(),
	);

	$result['has_default_template'] = false;
	$result['has_global_layouts']   = false;
	$global_layouts                 = array();

	foreach ( $ids as $id ) {
		$post = get_post( $id );

		if ( ! $post ) {
			continue;
		}

		$content          = json_decode( $post->post_content );
		$is_default       = (bool) get_post_meta( $id, '_et_default', true );
		$is_enabled       = (bool) get_post_meta( $id, '_et_enabled', true );
		$is_auto_title    = (bool) get_post_meta( $id, '_et_autogenerated_title', true );
		$is_global_header = (bool) get_post_meta( $id, '_et_header_layout_global', true );
		$is_global_body   = (bool) get_post_meta( $id, '_et_body_layout_global', true );
		$is_global_footer = (bool) get_post_meta( $id, '_et_footer_layout_global', true );

		$result['has_default_template'] = $result['has_default_template'] || $is_default;
		$result['has_global_layouts']   = $result['has_global_layouts'] || $is_global_header || $is_global_body || $is_global_footer;

		$data = et_theme_builder_library_save_temp_local_layout_data( $id, $content, $global_layouts );

		if ( $is_default ) {
			$global_layouts['body']   = et_()->array_get( $data, 'layouts.body.id', 0 );
			$global_layouts['header'] = et_()->array_get( $data, 'layouts.header.id', 0 );
			$global_layouts['footer'] = et_()->array_get( $data, 'layouts.footer.id', 0 );
		}

		$result['templates'][] = array_merge(
			array(
				'title'               => $post->post_title,
				'autogenerated_title' => $is_auto_title,
				'enabled'             => $is_enabled,
			),
			$data
		);

		if ( isset( $content->header ) ) {
			$layout_id        = $data['layouts']['header']['id'];
			$shortcode_object = et_fb_process_shortcode( $content->header->post_content );
			$global_colors    = $portability->get_theme_builder_library_used_global_colors( $shortcode_object );
			$presets_manager  = ET_Builder_Global_Presets_Settings::instance();
			$global_presets   = $presets_manager->get_global_presets();
			$layout_data      = array( $layout_id => $content->header->post_content );

			$result['layouts'][ $layout_id ] = array(
				'context'       => 'et_builder',
				'data'          => $layout_data,
				'images'        => $portability->get_theme_builder_library_images( $layout_data ),
				'thumbnails'    => $portability->get_theme_builder_library_thumbnail_images( $layout_data ),
				'post_type'     => et_theme_builder_get_valid_layout_post_type( 'header' ),
				'theme_builder' => array(
					'is_global' => $is_global_header,
				),
				'post_meta'     => isset( $content->header->post_meta ) ? $content->header->post_meta : array(),
			);

			if ( ! empty( $global_colors ) ) {
				$result['global_colors'][] = $global_colors;
			}

			if ( ! empty( $global_presets ) ) {
				$result['presets'] = $global_presets;
			}
		}

		if ( isset( $content->body ) ) {
			$layout_id        = $data['layouts']['body']['id'];
			$shortcode_object = et_fb_process_shortcode( $content->body->post_content );
			$global_colors    = $portability->get_theme_builder_library_used_global_colors( $shortcode_object );
			$presets_manager  = ET_Builder_Global_Presets_Settings::instance();
			$global_presets   = $presets_manager->get_global_presets();
			$layout_data      = array( $layout_id => $content->body->post_content );

			$result['layouts'][ $layout_id ] = array(
				'context'       => 'et_builder',
				'data'          => $layout_data,
				'images'        => $portability->get_theme_builder_library_images( $layout_data ),
				'thumbnails'    => $portability->get_theme_builder_library_thumbnail_images( $layout_data ),
				'post_type'     => et_theme_builder_get_valid_layout_post_type( 'body' ),
				'theme_builder' => array(
					'is_global' => $is_global_body,
				),
				'post_meta'     => isset( $content->body->post_meta ) ? $content->body->post_meta : array(),
			);

			if ( ! empty( $global_colors ) ) {
				$result['global_colors'][] = $global_colors;
			}

			if ( ! empty( $global_presets ) ) {
				$result['presets'] = $global_presets;
			}
		}

		if ( isset( $content->footer ) ) {
			$layout_id        = $data['layouts']['footer']['id'];
			$shortcode_object = et_fb_process_shortcode( $content->footer->post_content );
			$global_colors    = $portability->get_theme_builder_library_used_global_colors( $shortcode_object );
			$presets_manager  = ET_Builder_Global_Presets_Settings::instance();
			$global_presets   = $presets_manager->get_global_presets();
			$layout_data      = array( $layout_id => $content->footer->post_content );

			$result['layouts'][ $layout_id ] = array(
				'context'       => 'et_builder',
				'data'          => $layout_data,
				'images'        => $portability->get_theme_builder_library_images( $layout_data ),
				'thumbnails'    => $portability->get_theme_builder_library_thumbnail_images( $layout_data ),
				'post_type'     => et_theme_builder_get_valid_layout_post_type( 'footer' ),
				'theme_builder' => array(
					'is_global' => $is_global_footer,
				),
				'post_meta'     => isset( $content->footer->post_meta ) ? $content->footer->post_meta : array(),
			);

			if ( ! empty( $global_colors ) ) {
				$result['global_colors'][] = $global_colors;
			}

			if ( ! empty( $global_presets ) ) {
				$result['presets'] = $global_presets;
			}
		}

		et_theme_builder_library_remove_temp_layout_data( $data );
	}

	return $result;
}

/**
 * Gets Preset Items.
 *
 * @since ??
 *
 * @param int $item_id Item Id.
 *
 * @return array $items
 */
function et_theme_builder_library_get_set_items_data( $item_id ) {
	$items              = [];
	$maybe_template_ids = get_post_meta( $item_id, '_et_template_id' );
	$template_ids       = array_map( 'absint', $maybe_template_ids );

	foreach ( $template_ids as $template_id ) {
		$template_post = get_post( $template_id );

		if ( ! $template_post ) {
			continue;
		}

		$item        = new stdClass();
		$item->id    = $template_id;
		$item->title = $template_post->post_title;

		$items[] = $item;
	}

	return $items;
}

/**
 * Update library taxonomy terms.
 *
 * @since ??
 *
 * @param array  $payload             Item payload.
 * @param string $et_library_taxonomy Taxonomy.
 *
 * @return array $data
 */
function et_theme_builder_library_update_taxonomy_terms( $payload, $et_library_taxonomy ) {
	$et_library_taxonomy = sanitize_text_field( $et_library_taxonomy );

	if ( empty( $payload ) || empty( $et_library_taxonomy ) ) {
		return false;
	}

	$new_terms = array();

	foreach ( $payload as $single_item ) {
		$filter_type = sanitize_text_field( $single_item['filterType'] );

		switch ( $single_item['updateType'] ) {
			case 'remove':
				$term_id = (int) $single_item['id'];
				wp_delete_term( $term_id, $et_library_taxonomy );
				break;
			case 'rename':
				$term_id  = (int) $single_item['id'];
				$new_name = (string) $single_item['newName'];

				if ( '' !== $new_name ) {
					$updated_term_data = wp_update_term( $term_id, $et_library_taxonomy, array( 'name' => $new_name ) );

					if ( ! is_wp_error( $updated_term_data ) ) {
						$new_terms[] = array(
							'name'     => $new_name,
							'id'       => $updated_term_data['term_id'],
							'location' => 'local',
						);
					}
				}
				break;
			case 'add':
				$term_name     = (string) $single_item['id'];
				$new_term_data = wp_insert_term( $term_name, $et_library_taxonomy );

				if ( ! is_wp_error( $new_term_data ) ) {
					$new_terms[] = array(
						'name'     => $term_name,
						'id'       => $new_term_data['term_id'],
						'location' => 'local',
					);
				}
				break;
		}
	}

	return array(
		'newFilters' => $new_terms,
		'filterType' => $filter_type,
	);
}
