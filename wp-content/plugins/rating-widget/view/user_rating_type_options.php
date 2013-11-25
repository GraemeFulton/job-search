<?php
    $bbpress_support = ratingwidget()->IsBBPressInstalled();
    
    $is_accumulated = ($bbpress_support ? rw_settings()->is_user_accumulated : false);

?>
<div id="rw_user_rating_type_settings" class="has-sidebar has-right-sidebar">
    <div class="has-sidebar-content">
        <div class="postbox rw-body">
            <h3>Rating Type</h3>
            <div class="inside rw-ui-content-container rw-no-radius">
                <div class="rw-ui-img-radio rw-ui-hor<?php if ($is_accumulated) echo ' rw-selected';?>"<?php if (!$bbpress_support) echo 'onclick="alert(\'User Reputational ratings are only supported in the Premium package.\'); return false;"';?>>
                    <i class="rw-ui-sprite"></i> <input type="radio" name="rw_accumulated_user_rating" value="true" <?php if ($is_accumulated) echo ' checked="checked"';?>> <span>Reputational (Premium Feature) - average of all user's rated elements (forum posts, activites, blog posts, etc.)</span>
                </div>
                <div class="rw-ui-img-radio rw-ui-hor<?php if (!$is_accumulated) echo ' rw-selected';?>">
                    <i class="rw-ui-sprite"></i> <input type="radio" name="rw_accumulated_user_rating" value="false" <?php if (!$is_accumulated) echo ' checked="checked"';?>> <span>Standard - directly affected by rating user's profile page</span>
                </div>
            </div>
        </div>
    </div>
</div>
