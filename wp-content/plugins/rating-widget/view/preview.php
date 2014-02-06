<?php
    $options = rw_options();
?>
<div id="rw_wp_preview" class="postbox rw-body">
    <h3>Live Preview</h3>
    <div class="inside" style="padding: 10px;">
        <div id="rw_preview_container" style="text-align: <?php
            if ($options->advanced->layout->align->ver != "middle")
            {
                echo "center";
            }
            else
            {
                if ($options->advanced->layout->align->hor == "right"){
                    echo "left";
                }else{
                    echo "right";
                }
            }
        ?>;">
            <div id="rw_preview_star" class="rw-ui-container rw-urid-3"></div>
            <div id="rw_preview_nero" class="rw-ui-container rw-ui-nero rw-urid-17" style="display: none;"></div>
        </div>
        <div class="rw-js-container">
            <script type="text/javascript">
                var rwStar, rwNero;
                
                // Initialize ratings.
                function RW_Async_Init(){
                    RW.init("cfcd208495d565ef66e7dff9f98764da");
                    <?php
                        $b_type = $options->type;
                        $b_theme = $options->theme;
                        $b_style = $options->style;
                        
                        $types = array("star", "nero");
                        $default_themes = array("star" => DEF_STAR_THEME, "nero" => DEF_NERO_THEME);
                        $ratings_uids = array("star" => 3, "nero" => 17);
                        foreach($types as $type)
                        {
                    ?>
                    RW.initRating(<?php
                        if ($options->type !== $type)
                        {
                            $options->type = $type;
                            $options->theme = $default_themes[$type];
                            $options->style = "";
                        }
                        
                        echo $ratings_uids[$type] . ", ";
                        echo json_encode($options);
                        
                        // Recover.
                        $options->type = $b_type;
                        $options->theme = $b_theme;
                        $options->style = $b_style;                        
                    ?>);
                    <?php
                        }
                    ?>
                    RW.render(function(ratings){
                        rwStar = RWM.STAR = ratings[3].getInstances(0);
                        rwNero = RWM.NERO = ratings[17].getInstances(0);
                        
                        jQuery("#rw_theme_loader").hide();
                        jQuery("#rw_<?php echo $options->type;?>_theme_select").show();
                        
                        RWM.Set.sizeIcons(RW.TYPE.<?php echo strtoupper($options->type);?>);
                        
                        <?php
                            if ($options->type == "star"){
                                echo 'jQuery("#rw_preview_nero").hide();';
                                echo 'jQuery("#rw_preview_star").show();';
                            }else{
                                echo 'jQuery("#rw_preview_star").hide();';
                                echo 'jQuery("#rw_preview_nero").show();';
                            }
                        ?>
                        
                        // Set selected themes.
                        RWM.Set.selectedTheme.star = "<?php
                            echo (isset($options->type) && 
                                  $options->type == "star" && 
                                  isset($options->theme) && 
                                  $options->theme !== "") ? $options->theme : DEF_STAR_THEME;
                        ?>";
                        RWM.Set.selectedTheme.nero = "<?php
                            echo (isset($options->type) &&
                                  $options->type == "nero" &&
                                  isset($options->theme) && 
                                  $options->theme !== "") ? $options->theme : DEF_NERO_THEME;
                        ?>";
                        
                        RWM.Set.selectedType = RW.TYPE.<?php echo strtoupper($options->type);?>;
                        
                        // Add all themes inline css.
                        for (var t in RWT)
                        {
                            if (RWT[t].options.style == RW.STYLE.CUSTOM){
                                RW._addCustomImgStyle(RWT[t].options.imgUrl.large, [RWT[t].options.type], "theme", t);
                            }
                        }

                        RWM.Code.refresh();
                    }, false);
                }

                // Append RW JS lib.
                if (typeof(RW) == "undefined"){ 
                    (function(){
                        var rw = document.createElement("script"); rw.type = "text/javascript"; rw.async = true;
                        rw.src = "<?php echo rw_get_js_url('external.php');?>?wp=<?php echo WP_RW__VERSION;?>";
                        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(rw, s);
                    })();
                }
            </script>
        </div>
        <p class="submit" style="margin-top: 10px;">
            <input type="hidden" name="<?php echo rw_settings()->form_hidden_field_name; ?>" value="Y">
            <input type="hidden" id="rw_options_hidden" name="rw_options" value="" />
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            <?php if (false === WP_RW__USER_SECRET) : ?>
            <a href="<?php echo WP_RW__ADDRESS;?>/get-the-word-press-plugin/" onclick="_gaq.push(['_trackEvent', 'upgrade', 'wordpress', 'gopro_button', 1, true]); _gaq.push(['_link', this.href]); return false;" class="button-secondary gradient rw-upgrade-button" target="_blank">Upgrade Now!</a>
            <?php endif; ?>
        </p>
    </div>
</div>
