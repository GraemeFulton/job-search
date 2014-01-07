<?php



if(!class_exists('SP_BPCPM_MenuItemComponent'))
{
    
    
function SP_BPCPM_get_template_directory()
{
    return SP_BP_ABSPATH . 'templates';
}
       

/**
 * SP_BPCPM_MenuComponent custom menu component
 *
 * @author Sensible Plugins
 */
class SP_BPCPM_MenuItemComponent extends BP_Component
{
    private $slugs_menus; // An array of slug=>menu pairs
    
    protected $main_nav;
    protected $sub_nav;
    protected $wp_admin_nav;


    public $menu_item;
    public $menu_item_pos;
    public $submenus;
    
    public $options_manager;
    
            
    function __construct($menu_item, $menu_item_pos, $submenus, $options_manager) 
    {
        global $bp;

        $this->slugs_menus = array();
        
        $this->main_nav = array();
        $this->sub_nav = array();
        $this->wp_admin_nav = array();
        
        $this->menu_item = $menu_item;
        $this->menu_item_pos = $menu_item_pos;
        $this->submenus = $submenus;
        
        $this->options_manager = $options_manager;
        
        // Maintain backwards compatibility with BP < 1.7
        if( !class_exists('BP_Theme_Compat') )
            require( 'SP_BPCPM_BP17-compat.php' );
        
        parent::start( $this->get_menu_slug($this->menu_item), $this->get_menu_name($this->menu_item), SP_BP_ABSPATH );
        
                
        add_filter( 'bp_located_template', array(&$this, 'located_template_filter'), 10, 2 );
        
        
        // register as an active component in BP
	$bp->active_components[$this->id] = '1';
    }
    
    function get_menu_name($menu)
    {
        $title = $menu->post_title;
        if(empty($title) || $title=='')
        {
            $page = $this->get_menu_page($menu);
            if(!empty($page))
            {
                $title = $page->post_title;
            }
        }
        
        if(empty($title) || $title=='')
        {
            static $empty_title_count = 1;
            $title = "no_name" . $empty_title_count;
            $empty_title_count += 1;
        }
        
        return $title;
    }
    
    function get_menu_page($menu)
    {
        $page_id = get_post_meta( $menu->ID, '_menu_item_object_id', true );
        
        return get_page($page_id);
    }
    
    function get_menu_slug($menu)
    {
        $slug = NULL;
        
        $page = $this->get_menu_page($menu);
        if(!empty($page))
        {
            $slug = $page->post_name;
        }
            
        if(empty($slug) || $slug=='')
        {
            static $empty_slug_count = 1;
            $slug = "no_name" . $empty_slug_count;
            $empty_slug_count += 1;
        }
        
        $this->slugs_menus[$slug] = $menu;
        
        return $slug;
    }
    
    function get_menu_for_slug($slug)
    {
        return $this->slugs_menus[$slug];
    }
    
    function is_custom_link_menu($menu)
    {
        return $menu->type == 'custom';
    }


    function get_default_subnav_slug()
    {
        if(count($this->submenus))
            return $this->get_menu_slug ($this->submenus[0]);
        //else
        return $this->get_menu_slug($this->menu_item);
    }
    
    
    function get_content_for_slug($slug)
    {
        $page = get_page_by_path($slug);
        if(!$page)
            return '';
        
        $content = '';
        if($page)
            $content = apply_filters('the_content', $page->post_content);
        
        return $content;
    }
    
    
    function is_slug_public($slug)
    {
        return false;
    }

    
    
    
    function setup_globals() {
        
        $globals = array();
        
        parent::setup_globals( $globals );
    }
    
    /**
     * Setup BuddyBar navigation
     *
     * @global BuddyPress $bp The one true BuddyPress instance
     */
    function setup_nav() {
        
        // Add menu to the main navigation
        $menu_slug = $this->get_menu_slug($this->menu_item);
        
        $this->main_nav = array(
                          'name'                          => $this->get_menu_name($this->menu_item),
                          'slug'                          => $menu_slug,
                          'position'                      => $this->menu_item_pos,
                          'screen_function'               => array(&$this, 'menu_screen'),
                          'default_subnav_slug'           => $this->get_default_subnav_slug(),
                          'item_css_id'                   => $menu_slug,
                          'show_for_displayed_user'       => $this->is_slug_public($menu_slug)
                          );
        
        parent::setup_nav($this->main_nav, $this->sub_nav);
    }
    
    /**
     * Set up the Toolbar
     *
     * @global BuddyPress $bp The one true BuddyPress instance
     */
    function setup_admin_bar() {
        global $bp;
        
        // Menus for logged in user
        if ( is_user_logged_in() ) 
        {
            $menu_slug = $this->get_menu_slug($this->menu_item);
            
            
            // Setup the logged in user variables
            $user_domain  = bp_loggedin_user_domain();
            $menu_url = trailingslashit( $user_domain . $menu_slug );
            
            // Add the "My Account" sub menus
            $admin_item = array(
                                    'parent' => 'my-account-buddypress',
                                    'id'     => 'my-account-' . $menu_slug,
                                    'title'  => $this->get_menu_name($this->menu_item),
                                    'href'   => trailingslashit( $menu_url )
                               );
            array_unshift($this->wp_admin_nav, $admin_item);
        }
        
        parent::setup_admin_bar( $this->wp_admin_nav );
    }
    
    
    function menu_screen()
    {
        bp_core_load_template('menuitem_content');
    }
    
    function located_template_filter( $found_template, $templates ) 
    {
	global $bp;

	if (!bp_is_current_component($this->get_menu_slug($this->menu_item)))
            return $found_template;

	if ( empty( $found_template ) ) 
        {
		// register our theme compat directory
		//
		// this tells BP to look for templates in our plugin directory last
		// when the template isn't found in the parent / child theme
		bp_register_template_stack( 'SP_BPCPM_get_template_directory', 14 );

		// locate_template() will attempt to find the template in the
		// child and parent theme and return the located template when found
		//
		// note: this is only really relevant for bp-default themes as theme compat
		// will kick in on its own when this template isn't found
                $found_template = locate_template( 'members/single/plugins.php', false, false );
                
		// add our hook to inject content into BP
		//
		add_action( 'bp_template_content', array( &$this, 'get_menu_item_part' ) );        
	}
        
	return $found_template;
    }
    
    function get_menu_item_part()
    {
        bp_get_template_part( 'menuitem_content_part' );
    }
    
} 
    
} // endif class_exists


?>
