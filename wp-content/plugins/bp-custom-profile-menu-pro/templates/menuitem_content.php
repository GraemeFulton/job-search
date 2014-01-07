<?php get_header( 'buddypress' ); ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ); ?>

			<div id="item-header" role="complementary">

				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>

						<?php bp_get_displayed_user_nav(); ?>

						<?php do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php do_action( 'bp_before_member_body' ); ?>

                                
                                <?php
                                
                                $component_slug = bp_current_component();

                                global $bp;
                                $active_menu_component = $bp->$component_slug;
                                
                                $slug = bp_current_action();
                                if(!$slug)
                                    $slug = bp_current_item();
                                if(!$slug)
                                    $slug = bp_current_component();
                                
                                $menu = $active_menu_component->get_menu_for_slug($slug);
                                if(!$active_menu_component->is_custom_link_menu($menu))
                                {
                                    $content = $active_menu_component->get_content_for_slug($slug);
                                    echo $content;
                                }
                                else
                                {
                                    $link = $menu->url;
                                    echo "<iframe style='custom-link-iframe' src='$link' width=100% height=600px></iframe>";
                                }
           
				?>
                            

				<?php do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>