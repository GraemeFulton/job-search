<?php
if(bp_is_my_profile()){

  if(bp_is_profile_edit()){
    bp_profile_group_tabs();
  }
  if(bp_is_settings_component()){
    if ( bp_core_can_edit_settings() ) {
      bp_get_options_nav();
    }
  }
}
 ?>
