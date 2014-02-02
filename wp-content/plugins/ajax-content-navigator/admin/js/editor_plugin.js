(
	function(){
	
		tinymce.create(
			"tinymce.plugins.ACNShortcodes",
			{
				init: function(d,e) {},
				createControl:function(d,e)
				{
				
					if(d=="acn_shortcodes_button"){
					
						d=e.createMenuButton( "acn_shortcodes_button",{
							title:"Insert Shortcode",
							icons:false
							});
							
							var a=this;d.onRenderMenu.add(function(c,b){
							
							
								a.addImmediate(b,"Masonry/Pinterest Wall", '[acn]');
								a.addImmediate(b,"Grid/Equal Height Wall", '[acn layout=grid]');
								a.addImmediate(b,"WooCommerce Products Wall", '[acn type=product]');
								a.addImmediate(b,"WooCommerce Products Wall with Price Slider", '[acn type=product pricefilter=woocommerce]');
								a.addImmediate(b,"Wall including Meta Table", '[acn metakeys=meta_key1,meta_key2 metanames="Label 1, Label 2"]');
								
								b.addSeparator();
								
								c=b.addMenu({title:"Number of Columns"});
										a.addImmediate(c,"3-Columns Wall","[acn columns=3]" );
										a.addImmediate(c,"4-Columns Wall","[acn columns=4 posts=4 load=4 menu=no]" );
										a.addImmediate(c,"2-Columns Wall","[acn columns=2]" );
										a.addImmediate(c,"1-Column Wall","[acn columns=1]" );
								
								b.addSeparator();
								
								c=b.addMenu({title:"Wall by Custom Post Type"});
										a.addImmediate(c,"Posts only","[acn type=post]" );
										a.addImmediate(c,"Pages only","[acn type=page]" );
										a.addImmediate(c,"Products only","[acn type=product]" );
										a.addImmediate(c,"Custom Post Type","[acn type=\"your_custom_post_type_here\"]" );
								
								b.addSeparator();
								
								c=b.addMenu({title:"Wall by Author"});
										a.addImmediate(c,"Wall for Post Author","[acn author=post]" );
										a.addImmediate(c,"Wall for Author (author template)","[acn author=query]" );
										a.addImmediate(c,"Wall for Profile Owner (requires UPME)","[acn author=upme]" );
										
								b.addSeparator();
								
								a.addImmediate(b,"Wall for Specific Taxonomy", '[acn taxonomy=your_taxonomy]');
								a.addImmediate(b,"Wall for Multiple Taxonomies", '[acn taxonomies=category,post_tag]');
								a.addImmediate(b,"Wall for Specific Category", '[acn taxonomy=category term=category_slug]');
								
								b.addSeparator();
								
								a.addImmediate(b,"Load More Button +Wall", '[acn loadmorebutton=yes]');
								a.addImmediate(b,"Change number of posts", '[acn posts=number_of_first_posts load=number_of_loaded_posts]');
								a.addImmediate(b,"Default Active Panel/Tab", '[acn active=active_tab_number]');
								c=b.addMenu({title:"Sort Wall Results by"});
										a.addImmediate(c,"Date (default)","[acn sortby=date]" );
										a.addImmediate(c,"Alphabetically","[acn sortby=title]" );
										a.addImmediate(c,"Comment Count","[acn sortby=comment_count]" );
										a.addImmediate(c,"Most Liked Content","[acn sortby=meta_value_num]" );
										a.addImmediate(c,"Oldest first","[acn sortby=date_asc]" );
								
								b.addSeparator();
								
								a.addImmediate(b,"Hide Sorting Options", '[acn sort=no]');
								a.addImmediate(b,"Hide Post Options", '[acn options=no]');
								a.addImmediate(b,"Hide Social Bar", '[acn social=no]');
								a.addImmediate(b,"Hide Menu", '[acn menu=no]');

							});
						return d
					
					} // End IF Statement
					
					return null
				},
		
				addImmediate:function(d,e,a){d.add({title:e,onclick:function(){tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)}})}
				
			}
		);
		
		tinymce.PluginManager.add( "ACNShortcodes", tinymce.plugins.ACNShortcodes);
	}
)();