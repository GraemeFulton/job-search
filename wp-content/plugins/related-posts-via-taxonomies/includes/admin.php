<?php

$GLOBALS['relatedPostsViaTaxonomies_admin'] = new relatedPostsViaTaxonomies_admin();

add_action( 'admin_menu', array( 'relatedPostsViaTaxonomies_admin', 'add' ) );


class relatedPostsViaTaxonomies_admin
{

	function add() {
		$page = add_options_page( __('Related Posts via Taxonomies','related-posts-via-taxonomies'), __('Related Posts via Taxonomies','related-posts-via-taxonomies'), 'manage_options', 'related-posts-via-taxonomies', array( 'relatedPostsViaTaxonomies_admin', 'admin' ) );
		add_action( "admin_head-$page", array( 'relatedPostsViaTaxonomies_admin', 'head' ) );
	}

	function head() {
		?>
		<style type="text/css">
		<!--
		#relatedPostsViaTaxonomies-tabs {
			padding: 15px 5px 20px 5px;
			border-left: solid 1px #888888;
			border-right: solid 1px #888888;
			border-radius: 10px;
		}
		#relatedPostsViaTaxonomies-tabs ul {
			margin: 0;
			padding: 0 5px;
			border-bottom: solid 1px #888888;
		}
		#relatedPostsViaTaxonomies-tabs ul li {
			display: inline;
			margin: 1px;
			padding: 5px 20px;
			border: solid 1px #888888;
			border-radius: 5px 5px 0px 0px;
			background-color: #e3e3e3;
			cursor: pointer;
			color: #21759B;
			font-weight: bold;
		}
		#relatedPostsViaTaxonomies-tabs div {
			padding: 20px 15px;
		}
		.control-checkboxes {
			margin: 0.5em 0 0 1em;
		}
		.control-checkboxes a {
			cursor: pointer;
		}
		-->
		</style>
		<?php
	} // function head() {

	function admin() {
		$option_data = get_option("related_posts_via_taxonomies");
		$message = '';
		$custom_taxonomies = get_taxonomies( array( '_builtin' => false ), 'names' );
		if ( $_POST['submit'] ) {
			$option_post = array (
				"auto_display" => trim($_POST['auto_display']),
				"maximum_number_of_related_posts" => trim($_POST['maximum_number_of_related_posts']),
				"related_posts_title" => trim($_POST['related_posts_title']),
				"before_related_posts_title_and_related_posts" => trim($_POST['before_related_posts_title_and_related_posts']),
				"after_related_posts_title_and_related_posts" => trim($_POST['after_related_posts_title_and_related_posts']),
				"before_related_posts_title" => trim($_POST['before_related_posts_title']),
				"after_related_posts_title" => trim($_POST['after_related_posts_title']),
				"before_related_posts" => trim($_POST['before_related_posts']),
				"after_related_posts" => trim($_POST['after_related_posts']),
				"before_each_related_post" => trim($_POST['before_each_related_post']),
				"after_each_related_post" => trim($_POST['after_each_related_post']),
				"order_by" => trim($_POST['order_by']),
				"exclude_posts" =>
					preg_replace( "/,$/","" ,
						preg_replace( "/,\D*/","," ,
							preg_replace( "/[^0-9,]+/","" ,
								$_POST['exclude_posts']
							)
						)
					),
				"exclude_categories" => $_POST['exclude_categories'],
				"exclude_tags" => $_POST['exclude_tags'],
				"post_types" => $_POST['post_types'],
				"promotion_link" => $_POST['promotion_link'],
				"promotion_link_text" => $_POST['promotion_link_text'],
				"promotion_link_fontsize" => $_POST['promotion_link_fontsize'],
				"promotion_link_textalign" => $_POST['promotion_link_textalign'],
				"promotion_link_language" => $_POST['promotion_link_language'],
			);
			if ( $custom_taxonomies ) {
				foreach ( $custom_taxonomies as $custom_taxonomy ) {
					$option_data_key = "exclude_{$custom_taxonomy}";
					$option_post[$option_data_key] = $_POST[$option_data_key];
				}
			}
			if ( $option_data != $option_post ) {
				if( !update_option( "related_posts_via_taxonomies", $option_post ) ) {
					$message = __( "Updated Failed", 'related-posts-via-taxonomies' );
				}else{
					$message = __( "Updated", 'related-posts-via-taxonomies' );
					$option_data = get_option( "related_posts_via_taxonomies" );
				}
			}
		}
		?>
		<script>
		<!--
		jQuery( function() {
			jQuery( 'input[name=related_posts_title]' ) . val( '<?php echo $option_data['related_posts_title'] ?>' );
			jQuery( 'input[name=before_related_posts_title_and_related_posts]' ) . val( '<?php echo $option_data['before_related_posts_title_and_related_posts'] ?>' );
			jQuery( 'input[name=before_related_posts_title]' ) . val( '<?php echo $option_data['before_related_posts_title'] ?>' );
			jQuery( 'input[name=before_related_posts]' ) . val( '<?php echo $option_data['before_related_posts'] ?>' );
			jQuery( 'input[name=before_each_related_post]' ) . val( '<?php echo $option_data['before_each_related_post'] ?>' );
			jQuery( '#exclude_categories_check' ) . click( function() {
				jQuery( '#wrap_of_exclude_categories > input[type=checkbox]' ) . prop( 'checked', true );
			} );
			jQuery( '#exclude_categories_uncheck' ) . click( function() {
				jQuery( '#wrap_of_exclude_categories > input[type=checkbox]' ) . prop( 'checked', false );
			} );
			jQuery( '#exclude_categories_invert' ) . click( function() {
				jQuery( '#wrap_of_exclude_categories > input[type=checkbox]' ) . prop( 'checked', function( index, oldValue ){
					return !oldValue;
				} );
			} );
			jQuery( '#exclude_tags_check' ) . click( function() {
				jQuery( '#wrap_of_exclude_tags > input[type=checkbox]' ) . prop( 'checked', true );
			} );
			jQuery( '#exclude_tags_uncheck' ) . click( function() {
				jQuery( '#wrap_of_exclude_tags > input[type=checkbox]' ) . prop( 'checked', false );
			} );
			jQuery( '#exclude_tags_invert' ) . click( function() {
				jQuery( '#wrap_of_exclude_tags > input[type=checkbox]' ) . prop( 'checked', function( index, oldValue ){
					return !oldValue;
				} );
			} );
			jQuery( '#relatedPostsViaTaxonomies-tabs > ul > li' ) . click( function () {
				var str = jQuery( 'input', this ) . val();
				jQuery( '#relatedPostsViaTaxonomies-tabs > div' ) . not( str ) . css( 'display', 'none' );
				jQuery( str ) . css( 'display', 'block' );
				jQuery( this ) . css( { 'backgroundColor': '#ffffff', 'border-bottom': 'none', 'color': '#222222' } );
				jQuery( '#relatedPostsViaTaxonomies-tabs > ul > li' ) . not( this ) . css( { 'backgroundColor': '#e3e3e3', 'border-bottom': 'solid 1px #888888', 'color': '#21759B' } );
			} ) . first() . click();
		} );
		// -->
		</script>
		<?php 
		$custom_taxonomies = get_taxonomies( array( '_builtin' => false ), 'names' );
		if ( $custom_taxonomies ) :
			foreach ( $custom_taxonomies as $custom_taxonomy ) :
		?>
				<script>
				<!--
				jQuery( function() {
					jQuery( '#exclude_<?php echo "{$custom_taxonomy}"; ?>_check' ) . click( function() {
						jQuery( '#wrap_of_exclude_<?php echo "{$custom_taxonomy}"; ?> > input[type=checkbox]' ) . prop( 'checked', true );
					} );
					jQuery( '#exclude_<?php echo "{$custom_taxonomy}"; ?>_uncheck' ) . click( function() {
						jQuery( '#wrap_of_exclude_<?php echo "{$custom_taxonomy}"; ?> > input[type=checkbox]' ) . prop( 'checked', false );
					} );
					jQuery( '#exclude_<?php echo "{$custom_taxonomy}"; ?>_invert' ) . click( function() {
					jQuery( '#wrap_of_exclude_<?php echo "{$custom_taxonomy}"; ?> > input[type=checkbox]' ) . prop( 'checked', function( index, oldValue ){
							return !oldValue;
						} );
					} );
				} );
				// -->
				</script>
		<?php
			endforeach;
		endif;
		?>
		<div class="wrap">
			<h2><?php _e( 'Related Posts via Taxonomies - Options', 'related-posts-via-taxonomies' ) ?></h2>
			<ul>
				<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FF3U9VJDHT9DU" target="_blank"><?php _e( 'Please pay if you like this plugin.', 'related-posts-via-taxonomies' ); ?></a></li>
				<li><?php _e( "Official page", 'related-posts-via-taxonomies' ); ?> : <a href="http://alphasis.info/developments/wordpress-plugins/related-posts-via-taxonomies/" target="_blank"><?php _e( "English", 'related-posts-via-taxonomies' ); ?></a> / <a href="http://alphasis.info/kaihatu/wordpress-plugins/related-posts-via-taxonomies/" target="_blank"><?php _e( "Japanese", 'related-posts-via-taxonomies' ); ?></a></li>
			</ul>
			<div class="message"><p><?php echo $message; ?></p></div>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=related-posts-via-taxonomies">

			<div id="relatedPostsViaTaxonomies-tabs">

				<ul>
					<li>
						<input id="#relatedPostsViaTaxonomies-tab-1" type="hidden" value="#relatedPostsViaTaxonomies-tab-1-contents" />
						<?php _e( 'Display','related-posts-via-taxonomies' ) ?>
					</li>
					<li>
						<input id="#relatedPostsViaTaxonomies-tab-2" type="hidden" value="#relatedPostsViaTaxonomies-tab-2-contents" />
						<?php _e( 'Order','related-posts-via-taxonomies' ) ?>
					</li>
					<li>
						<input id="#relatedPostsViaTaxonomies-tab-3" type="hidden" value="#relatedPostsViaTaxonomies-tab-3-contents" />
						<?php _e( 'Exclude','related-posts-via-taxonomies' ) ?>
					</li>
					<li>
						<input id="#relatedPostsViaTaxonomies-tab-4" type="hidden" value="#relatedPostsViaTaxonomies-tab-4-contents" />
						<?php _e( 'Post types','related-posts-via-taxonomies' ) ?>
					</li>
					<li>
						<input id="#relatedPostsViaTaxonomies-tab-5" type="hidden" value="#relatedPostsViaTaxonomies-tab-5-contents" />
						<?php _e( 'Promotion','related-posts-via-taxonomies' ) ?>
					</li>
				</ul>

				<div id="relatedPostsViaTaxonomies-tab-1-contents">

					<table class="form-table">
	
						<tr valign="top">
							<th scope="row"><?php _e( "Auto display", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input id="relatedPostsViaTaxonomies-auto-display" type="checkbox" name="auto_display" value="yes" <?php if( $option_data['auto_display'] ){ echo " checked"; } ?> />
								<label for="relatedPostsViaTaxonomies-auto-display"><?php _e( 'This option automatically displays the related posts list after the content on any single post page.', 'related-posts-via-taxonomies' ); ?></label>
								<br /><?php _e( 'If this option is off, you will need to manually insert "display_related_posts_via_taxonomies()" into your theme files.', 'related-posts-via-taxonomies' ); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Maximum number of related posts", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="maximum_number_of_related_posts" value="<?php echo $option_data['maximum_number_of_related_posts']; ?>" size="2" />
								<?php _e('If you do not enter anything','related-posts-via-taxonomies'); echo ': 10'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Related posts title", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="related_posts_title" size="50" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': '; _e('Related Posts'); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Before related posts title and related posts", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="before_related_posts_title_and_related_posts" size="50" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;div id=&#34;related-posts-via-taxonomies&#34;&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "After related posts title and related posts", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="after_related_posts_title_and_related_posts" value="<?php echo $option_data['after_related_posts_title_and_related_posts']; ?>" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;/div&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Before related posts title", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="before_related_posts_title" size="50" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;h2 id=&#34;related-posts-via-taxonomies-title&#34;&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "After related posts title", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="after_related_posts_title" value="<?php echo $option_data['after_related_posts_title']; ?>" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;/h2&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Before related posts", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="before_related_posts" size="50" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;ul id=&#34;related-posts-via-taxonomies-list&#34;&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "After related posts", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="after_related_posts" value="<?php echo $option_data['after_related_posts']; ?>" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;/ul&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Before each related post", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="before_each_related_post" size="50" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;li class=&#34;related-posts-via-taxonomies-item&#34;&gt;'; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "After each related post", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="after_each_related_post" value="<?php echo $option_data['after_each_related_post']; ?>" />
								<?php _e('For example','related-posts-via-taxonomies'); echo ': &lt;/li&gt;'; ?>
							</td>
						</tr>
	
					</table>
		
				</div>
				<div id="relatedPostsViaTaxonomies-tab-2-contents">

					<table class="form-table">
	
						<tr valign="top">
							<th scope="row"><?php _e('Order By', 'related-posts-via-taxonomies'); ?>:</th>
							<td>
								<input id="related_scores_high__speedy" name="order_by" type="radio" value="related_scores_high__speedy"<?php if($option_data['order_by']=="related_scores_high__speedy")echo ' checked'; ?> /><label for="related_scores_high__speedy"><?php _e(' Related Scores : High', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;(&nbsp;<?php _e('Speedy', 'related-posts-via-taxonomies'); ?>&nbsp;)</label>
								<br /><input id="related_scores_high__date_published_new" name="order_by" type="radio" value="related_scores_high__date_published_new"<?php if($option_data['order_by']=="related_scores_high__date_published_new")echo ' checked'; ?> /><label for="related_scores_high__date_published_new"><?php _e(' Related Scores : High', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Published : New', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;(&nbsp;<?php _e('Default setting', 'related-posts-via-taxonomies'); ?>&nbsp;)</label>
								<br /><input id="related_scores_high__date_published_old" name="order_by" type="radio" value="related_scores_high__date_published_old"<?php if($option_data['order_by']=="related_scores_high__date_published_old")echo ' checked'; ?> /><label for="related_scores_high__date_published_old"><?php _e(' Related Scores : High', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Published : Old', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_low__date_published_new" name="order_by" type="radio" value="related_scores_low__date_published_new"<?php if($option_data['order_by']=="related_scores_low__date_published_new")echo ' checked'; ?> /><label for="related_scores_low__date_published_new"><?php _e(' Related Scores : Low', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Published : New', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_low__date_published_old" name="order_by" type="radio" value="related_scores_low__date_published_old"<?php if($option_data['order_by']=="related_scores_low__date_published_old")echo ' checked'; ?> /><label for="related_scores_low__date_published_old"><?php _e(' Related Scores : Low', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Published : Old', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_high__date_modified_new" name="order_by" type="radio" value="related_scores_high__date_modified_new"<?php if($option_data['order_by']=="related_scores_high__date_modified_new")echo ' checked'; ?> /><label for="related_scores_high__date_modified_new"><?php _e(' Related Scores : High', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Modified : New', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_high__date_modified_old" name="order_by" type="radio" value="related_scores_high__date_modified_old"<?php if($option_data['order_by']=="related_scores_high__date_modified_old")echo ' checked'; ?> /><label for="related_scores_high__date_modified_old"><?php _e(' Related Scores : High', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Modified : Old', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_low__date_modified_new" name="order_by" type="radio" value="related_scores_low__date_modified_new"<?php if($option_data['order_by']=="related_scores_low__date_modified_new")echo ' checked'; ?> /><label for="related_scores_low__date_modified_new"><?php _e(' Related Scores : Low', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Modified : New', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="related_scores_low__date_modified_old" name="order_by" type="radio" value="related_scores_low__date_modified_old"<?php if($option_data['order_by']=="related_scores_low__date_modified_old")echo ' checked'; ?> /><label for="related_scores_low__date_modified_old"><?php _e(' Related Scores : Low', 'related-posts-via-taxonomies'); ?>&nbsp;&nbsp;/&nbsp;<?php _e(' Date Modified : Old', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="date_published_new" name="order_by" type="radio" value="date_published_new"<?php if($option_data['order_by']=="date_published_new")echo ' checked'; ?> /><label for="date_published_new"><?php _e(' Date Published : New', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="date_published_old" name="order_by" type="radio" value="date_published_old"<?php if($option_data['order_by']=="date_published_old")echo ' checked'; ?> /><label for="date_published_old"><?php _e(' Date Published : Old', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="date_modified_new" name="order_by" type="radio" value="date_modified_new"<?php if($option_data['order_by']=="date_modified_new")echo ' checked'; ?> /><label for="date_modified_new"><?php _e(' Date Modified : New', 'related-posts-via-taxonomies'); ?></label>
								<br /><input id="date_modified_old" name="order_by" type="radio" value="date_modified_old"<?php if($option_data['order_by']=="date_modified_old")echo ' checked'; ?> /><label for="date_modified_old"><?php _e(' Date Modified : Old', 'related-posts-via-taxonomies'); ?></label>
							</td>
						</tr>

					</table>

				</div>
				<div id="relatedPostsViaTaxonomies-tab-3-contents">

					<table class="form-table">

						<tr valign="top">
							<th scope="row"><?php _e( "Exclude (Posts)", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input type="text" name="exclude_posts" value="<?php echo $option_data['exclude_posts']; ?>" size="50" />
								<?php _e('The IDs of any posts you want to exclude, separated by commas.','related-posts-via-taxonomies'); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e( "Exclude (Categories)", 'related-posts-via-taxonomies' ); ?>:
								<p class="control-checkboxes">
									<a id="exclude_categories_check"><?php _e( 'Check all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_categories_uncheck"><?php _e( 'Uncheck all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_categories_invert"><?php _e( 'Invert selection', 'related-posts-via-taxonomies' ); ?></a>
								</p>
							</th>
							<td id="wrap_of_exclude_categories">
		<?php
		$terms = get_terms( 'category', 'hide_empty=0&orderby=slug' );
		$count = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) :
		?>
								<input id="exclude_categories_<?php echo "{$term->term_taxonomy_id}"; ?>" type="checkbox" name="exclude_categories[]" value="<?php echo "{$term->term_taxonomy_id}"; ?>" <?php if ( $option_data['exclude_categories'] ) { if( in_array( $term->term_taxonomy_id, $option_data['exclude_categories'] ) ) { echo " checked"; } } ?> />
								<label for="exclude_categories_<?php echo "{$term->term_taxonomy_id}"; ?>"><?php echo "{$term->name} ( {$term->count} ) [ " . urldecode( $term->slug ) . " ]</label><br />"; ?>
			<?php endforeach; ?>
		<?php endif; ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e( "Exclude (Tags)", 'related-posts-via-taxonomies' ); ?>:
								<p class="control-checkboxes">
									<a id="exclude_tags_check"><?php _e( 'Check all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_tags_uncheck"><?php _e( 'Uncheck all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_tags_invert"><?php _e( 'Invert selection', 'related-posts-via-taxonomies' ); ?></a>
								</p>
							</th>
							<td id="wrap_of_exclude_tags">
		<?php
		$terms = get_terms( 'post_tag', 'hide_empty=0&orderby=slug' );
		$count = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) :
		?>
								<input id="exclude_tags_<?php echo "{$term->term_taxonomy_id}"; ?>" type="checkbox" name="exclude_tags[]" value="<?php echo "{$term->term_taxonomy_id}"; ?>" <?php if ( $option_data['exclude_tags'] ) { if( in_array( $term->term_taxonomy_id, $option_data['exclude_tags'] ) ) { echo " checked"; } } ?> />
								<label for="exclude_tags_<?php echo "{$term->term_taxonomy_id}"; ?>"><?php echo "{$term->name} ( {$term->count} ) [ " . urldecode( $term->slug ) . " ]</label><br />"; ?>
			<?php endforeach; ?>
		<?php endif; ?>
							</td>
						</tr>

		<?php if ( $custom_taxonomies ) : ?>
			<?php foreach ( $custom_taxonomies as $custom_taxonomy ) : ?>
				<?php $option_data_key = "exclude_{$custom_taxonomy}"; ?>
						<tr valign="top">
							<th scope="row">
								<?php _e( 'Exclude', 'related-posts-via-taxonomies' ); ?>(<?php echo "{$custom_taxonomy}"; ?>):
								<p class="control-checkboxes">
									<a id="exclude_<?php echo "{$custom_taxonomy}"; ?>_check"><?php _e( 'Check all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_<?php echo "{$custom_taxonomy}"; ?>_uncheck"><?php _e( 'Uncheck all', 'related-posts-via-taxonomies' ); ?></a><br />
									<a id="exclude_<?php echo "{$custom_taxonomy}"; ?>_invert"><?php _e( 'Invert selection', 'related-posts-via-taxonomies' ); ?></a>
								</p>
							</th>
							<td id="wrap_of_exclude_<?php echo "{$custom_taxonomy}"; ?>">
				<?php
				$terms = get_terms( $custom_taxonomy, 'hide_empty=0&orderby=slug' );
				$count = count( $terms );
				if ( $count > 0 ) :
					foreach ( $terms as $term ) :
				?>
								<input id="exclude_<?php echo "{$custom_taxonomy}"; ?>_<?php echo "{$term->term_taxonomy_id}"; ?>" type="checkbox" name="exclude_<?php echo "{$custom_taxonomy}"; ?>[]" value="<?php echo "{$term->term_taxonomy_id}"; ?>" <?php if ( $option_data[$option_data_key] ) { if( in_array( $term->term_taxonomy_id, $option_data[$option_data_key] ) ) { echo " checked"; } } ?> />
								<label for="exclude_<?php echo "{$custom_taxonomy}"; ?>_<?php echo "{$term->term_taxonomy_id}"; ?>"><?php echo "{$term->name} ( {$term->count} ) [ " . urldecode( $term->slug ) . " ]</label><br />"; ?>
					<?php endforeach; ?>
				<?php endif; ?>
							</td>
						</tr>
			<?php endforeach; ?>
		<?php endif; ?>

					</table>

				</div>
				<div id="relatedPostsViaTaxonomies-tab-4-contents">

					<table class="form-table">

						<tr valign="top">
							<th scope="row"><?php _e( "Post types", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input id="post_types_post" type="checkbox" name="post_types[]" value="post" <?php if( $option_data['post_types'] ) { if( in_array( 'post', $option_data['post_types'] ) ) { echo " checked"; } } ?> />
								<label for="post_types_post"><?php _e( 'post', 'related-posts-via-taxonomies' ); ?></label>
		<?php $custom_post_types = get_post_types( array( '_builtin' => false ), 'names' ); ?>
		<?php if ($custom_post_types ) : ?>
			<?php foreach ( $custom_post_types as $custom_post_type ) : ?>
								<br /><input id="post_types_<?php echo $custom_post_type; ?>" type="checkbox" name="post_types[]" value="<?php echo $custom_post_type; ?>" <?php if( $option_data['post_types'] ) { if( in_array( $custom_post_type, $option_data['post_types'] ) ) { echo " checked"; } } ?> />
								<label for="post_types_<?php echo $custom_post_type; ?>"><?php echo $custom_post_type; ?></label>
			<?php endforeach; ?>
		<?php endif; ?>
							</td>
						</tr>
	
					</table>

				</div>
				<div id="relatedPostsViaTaxonomies-tab-5-contents">

					<table class="form-table">
	
						<tr valign="top">
							<th scope="row"><?php _e( "Could you promote this plugin?", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input id="promotion_link" type="checkbox" name="promotion_link" value="yes" <?php if ( $option_data['promotion_link'] ) { echo 'checked '; }?>/>
								<label for="promotion_link"><?php _e( 'If this option is enabled, displays the link to the official page of this plugin after the related posts list.', 'related-posts-via-taxonomies' ); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Link text", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input id="promotion_link_text_1" type="radio" name="promotion_link_text" value="To the official site of Related Posts via Taxonomies." <?php if ( $option_data['promotion_link_text'] == 'To the official site of Related Posts via Taxonomies.' ) { echo 'checked '; }?>/>
								<label for="promotion_link_text_1">To the official site of Related Posts via Taxonomies.</label>
								<br />
								<input id="promotion_link_text_2" type="radio" name="promotion_link_text" value="Related Posts via Taxonomies" <?php if ( $option_data['promotion_link_text'] == 'Related Posts via Taxonomies' ) { echo 'checked '; }?>/>
								<label for="promotion_link_text_2">Related Posts via Taxonomies</label>
								<br />
								<input id="promotion_link_text_3" type="radio" name="promotion_link_text" value="Related Posts Plugin by ALPHASIS" <?php if ( $option_data['promotion_link_text'] == 'Related Posts Plugin by ALPHASIS' ) { echo 'checked '; }?>/>
								<label for="promotion_link_text_3">Related Posts Plugin by ALPHASIS</label>
								<br />
								<input id="promotion_link_text_4" type="radio" name="promotion_link_text" value="Related Posts Plugin" <?php if ( $option_data['promotion_link_text'] == 'Related Posts Plugin' ) { echo 'checked '; }?>/>
								<label for="promotion_link_text_4">Related Posts Plugin</label>
								<br />
								<input id="promotion_link_text_5" type="radio" name="promotion_link_text" value="ALPHASIS" <?php if ( $option_data['promotion_link_text'] == 'ALPHASIS' ) { echo 'checked '; }?>/>
								<label for="promotion_link_text_5">ALPHASIS</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">font-size:</th>
							<td>
								<input id="promotion_link_fontsize_9" type="radio" name="promotion_link_fontsize" value="9" <?php if ( $option_data['promotion_link_fontsize'] == 9 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_9" style="margin-right: 15px; font-size: 9px;">9</label>
								<input id="promotion_link_fontsize_10" type="radio" name="promotion_link_fontsize" value="10" <?php if ( $option_data['promotion_link_fontsize'] == 10 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_10" style="margin-right: 15px; font-size: 10px;">10</label>
								<input id="promotion_link_fontsize_11" type="radio" name="promotion_link_fontsize" value="11" <?php if ( $option_data['promotion_link_fontsize'] == 11 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_11" style="margin-right: 15px; font-size: 11px;">11</label>
								<input id="promotion_link_fontsize_12" type="radio" name="promotion_link_fontsize" value="12" <?php if ( $option_data['promotion_link_fontsize'] == 12 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_12" style="margin-right: 15px; font-size: 12px;">12</label>
								<input id="promotion_link_fontsize_13" type="radio" name="promotion_link_fontsize" value="13" <?php if ( $option_data['promotion_link_fontsize'] == 13 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_13" style="margin-right: 15px; font-size: 13px;">13</label>
								<input id="promotion_link_fontsize_14" type="radio" name="promotion_link_fontsize" value="14" <?php if ( $option_data['promotion_link_fontsize'] == 14 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_14" style="margin-right: 15px; font-size: 14px;">14</label>
								<input id="promotion_link_fontsize_15" type="radio" name="promotion_link_fontsize" value="15" <?php if ( $option_data['promotion_link_fontsize'] == 15 ) { echo 'checked '; }?>/>
								<label for="promotion_link_fontsize_15" style="margin-right: 15px; font-size: 15px;">15</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">text-align:</th>
							<td>
								<input id="promotion_link_textalign_left" type="radio" name="promotion_link_textalign" value="left" <?php if ( $option_data['promotion_link_textalign'] == 'left' ) { echo 'checked '; }?>/>
								<label for="promotion_link_textalign_left" style="margin-right: 15px;">left</label>
								<input id="promotion_link_textalign_center" type="radio" name="promotion_link_textalign" value="center" <?php if ( $option_data['promotion_link_textalign'] == 'center' ) { echo 'checked '; }?>/>
								<label for="promotion_link_textalign_center" style="margin-right: 15px;">center</label>
								<input id="promotion_link_textalign_right" type="radio" name="promotion_link_textalign" value="right" <?php if ( $option_data['promotion_link_textalign'] == 'right' ) { echo 'checked '; }?>/>
								<label for="promotion_link_textalign_right" style="margin-right: 15px;">right</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Language of the official page", 'related-posts-via-taxonomies' ); ?>:</th>
							<td>
								<input id="promotion_link_language_english" type="radio" name="promotion_link_language" value="english" <?php if ( $option_data['promotion_link_language'] == 'english' ) { echo 'checked '; }?>/>
								<label for="promotion_link_language_english" style="margin-right: 15px;"><?php _e( "English", 'related-posts-via-taxonomies' ); ?></label>
								<input id="promotion_link_language_japanese" type="radio" name="promotion_link_language" value="japanese" <?php if ( $option_data['promotion_link_language'] == 'japanese' ) { echo 'checked '; }?>/>
								<label for="promotion_link_language_japanese" style="margin-right: 15px;"><?php _e( "Japanese", 'related-posts-via-taxonomies' ); ?></label>
							</td>
						</tr>

					</table>

				</div>
			</div>

				<p class="submit">
				<input type="submit" value="<?php _e('Save changes','related-posts-via-taxonomies') ?>" name="submit" />
				</p>
			
			</form>
		</div>
		<?php
	} // function admin() {

} // class relatedPostsViaTaxonomies_admin



?>
