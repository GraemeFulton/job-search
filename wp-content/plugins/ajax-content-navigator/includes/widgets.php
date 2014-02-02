<?php

add_action( 'widgets_init', 'acn_widget' );
function acn_widget() { register_widget( 'acn_widget_func' ); }

class acn_widget_func extends WP_Widget {

	function acn_widget_func() {
		$widget_ops = array( 'classname' => 'acn_widget_func', 'description' => __('Displays your ACN Wall in the sidebar as a widget.', 'acn') );
		
		$control_ops = array( 'id_base' => 'acn_widget_func' );
		
		$this->WP_Widget( 'acn_widget_func', __('ACN Wall ', 'acn'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $acn;

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];
		$options = $instance['options'];
		$active = $instance['active'];
		$menu = $instance['menu'];
		$sort = $instance['sort'];
		$social = $instance['social'];
		$posts = $instance['posts'];
		$load = $instance['load'];
		$forcetaxonomy = $instance['forcetaxonomy'];
		$forcetaxonomies = $instance['forcetaxonomies'];
		$forceterm = $instance['forceterm'];
		$excerpt = $instance['excerpt'];
		$pricefilter = $instance['pricefilter'];
		$metakeys = $instance['metakeys'];
		$metanames = $instance['metanames'];
		$author = $instance['author'];

		// Display widget
		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		
		$instance['taxonomies'] = $forcetaxonomies;
		$instance['taxonomy'] = $forcetaxonomy;
		$instance['term'] = $forceterm;
		$instance['sidebar'] = 'yes';
		echo $acn->show( $instance );
		
		echo $after_widget;

	}

	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['options'] = strip_tags( $new_instance['options'] );
		$instance['active'] = strip_tags( $new_instance['active'] );
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		$instance['sort'] = strip_tags( $new_instance['sort'] );
		$instance['social'] = strip_tags( $new_instance['social'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );
		$instance['load'] = strip_tags( $new_instance['load'] );
		$instance['forcetaxonomy'] = strip_tags( $new_instance['forcetaxonomy'] );
		$instance['forcetaxonomies'] = strip_tags( $new_instance['forcetaxonomies'] );
		$instance['forceterm'] = strip_tags( $new_instance['forceterm'] );
		$instance['excerpt'] = strip_tags( $new_instance['excerpt'] );
		$instance['pricefilter'] = strip_tags( $new_instance['pricefilter'] );
		$instance['metakeys'] = strip_tags( $new_instance['metakeys'] );
		$instance['metanames'] = strip_tags( $new_instance['metanames'] );
		$instance['author'] = strip_tags( $new_instance['author'] );

		return $instance;
	}

	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => null, 'type' => null, 'options' => null, 'active' => null, 'menu' => null, 'sort' => null, 'social' => null, 'posts' => 1, 'load' => 1 , 'forcetaxonomy' => null, 'forcetaxonomies' => null, 'forceterm' => null, 'exclude_categories' => null, 'excerpt' => 20, 'pricefilter' => null, 'metakeys' => null, 'metanames' => null, 'author' => null);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Wall Type:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="">
				<option value=""<?php selected('', $instance['type']); ?>><?php _e('All posts','acn'); ?></option>
				<option value="product"<?php selected('product', $instance['type']); ?>><?php _e('Products','acn'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'options' ); ?>"><?php _e('Show Wall Options:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'options' ); ?>" name="<?php echo $this->get_field_name( 'options' ); ?>" class="">
				<option value=""<?php selected('', $instance['options']); ?>><?php _e('Show','acn'); ?></option>
				<option value="no"<?php selected('no', $instance['options']); ?>><?php _e('Hide','acn'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php _e('Show Wall Filters:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>" class="">
				<option value=""<?php selected('', $instance['menu']); ?>><?php _e('Show','acn'); ?></option>
				<option value="no"<?php selected('no', $instance['menu']); ?>><?php _e('Hide','acn'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'sort' ); ?>"><?php _e('Show Sort By:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'sort' ); ?>" name="<?php echo $this->get_field_name( 'sort' ); ?>" class="">
				<option value=""<?php selected('', $instance['sort']); ?>><?php _e('Show','acn'); ?></option>
				<option value="no"<?php selected('no', $instance['sort']); ?>><?php _e('Hide','acn'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'social' ); ?>"><?php _e('Show Social Bar:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'social' ); ?>" name="<?php echo $this->get_field_name( 'social' ); ?>" class="">
				<option value=""<?php selected('', $instance['social']); ?>><?php _e('Show','acn'); ?></option>
				<option value="no"<?php selected('no', $instance['social']); ?>><?php _e('Hide','acn'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'posts' ); ?>"><?php _e('Number of Items to show first:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'posts' ); ?>" name="<?php echo $this->get_field_name( 'posts' ); ?>" value="<?php echo $instance['posts']; ?>" class="widefat" /><br />
			<small><?php _e('How many items to show on first view.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'load' ); ?>"><?php _e('Number of Items to load:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'load' ); ?>" name="<?php echo $this->get_field_name( 'load' ); ?>" value="<?php echo $instance['load']; ?>" class="widefat" /><br />
			<small><?php _e('How many items to load when user scroll.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'forcetaxonomy' ); ?>"><?php _e('Make Wall for specific Taxonomy:', 'ocart'); ?></label>
			<select id="<?php echo $this->get_field_id( 'forcetaxonomy' ); ?>" name="<?php echo $this->get_field_name( 'forcetaxonomy' ); ?>" class="widefat">
				<option value=""<?php selected('', $instance['forcetaxonomy']); ?>><?php _e('Use Default','acn'); ?></option>
				<?php
				$taxonomies=get_taxonomies('','names');
				if  ($taxonomies) {
					foreach($taxonomies as $taxonomy) {
				?>
				<option value="<?php echo $taxonomy; ?>"<?php selected($taxonomy, $instance['forcetaxonomy']); ?>>
					<?php $the_tax = get_taxonomy( $taxonomy ); echo $the_tax->labels->name;?>
				</option>
				<?php
					}
				}
				?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'forcetaxonomies' ); ?>"><?php _e('Multiple Taxonomies:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'forcetaxonomies' ); ?>" name="<?php echo $this->get_field_name( 'forcetaxonomies' ); ?>" value="<?php echo $instance['forcetaxonomies']; ?>" class="widefat" /><br />
			<small><?php _e('If you want to limit the wall for specific taxonomies, enter a comma seperated list of the taxonomies you want to enable in this wall.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'forceterm' ); ?>"><?php _e('Make Wall for specific Term/Category:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'forceterm' ); ?>" name="<?php echo $this->get_field_name( 'forceterm' ); ?>" value="<?php echo $instance['forceterm']; ?>" class="widefat" /><br />
			<small><?php _e('Please enter term slug. e.g. shoes','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'active' ); ?>"><?php _e('Active Pane:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'active' ); ?>" name="<?php echo $this->get_field_name( 'active' ); ?>" value="<?php echo $instance['active']; ?>" class="widefat" /><br />
			<small><?php _e('You can change active/toggled tab If you choose to show menu/filters.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>"><?php _e('Excerpt/Teaser Length in Words:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" value="<?php echo $instance['excerpt']; ?>" class="widefat" />
		</p>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'pricefilter' ); ?>"><?php _e('Show Price Filter:', 'acn'); ?></label>
			<select id="<?php echo $this->get_field_id( 'pricefilter' ); ?>" name="<?php echo $this->get_field_name( 'pricefilter' ); ?>" class="">
				<option value=""<?php selected('', $instance['pricefilter']); ?>><?php _e('Do not use','acn'); ?></option>
				<option value="woocommerce"<?php selected('woocommerce', $instance['pricefilter']); ?>><?php _e('WooCommerce','acn'); ?></option>
			</select>
		</p>
		<?php } ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'metakeys' ); ?>"><?php _e('Meta Keys:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'metakeys' ); ?>" name="<?php echo $this->get_field_name( 'metakeys' ); ?>" value="<?php echo $instance['metakeys']; ?>" class="widefat" /><br />
			<small><?php _e('Comma seperated list of meta keys to display in meta table.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'metanames' ); ?>"><?php _e('Meta Labels/Names:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'metanames' ); ?>" name="<?php echo $this->get_field_name( 'metanames' ); ?>" value="<?php echo $instance['metanames']; ?>" class="widefat" /><br />
			<small><?php _e('Comma seperated list of meta names/labels to display in meta table.','acn'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php _e('Author Wall:', 'acn'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" value="<?php echo $instance['author']; ?>" class="widefat" /><br />
			<small><?php _e('Can be <code>auto</code> or <code>Author ID</code>. Display posts for specific author only.','acn'); ?></small>
		</p>

	<?php
	}
}