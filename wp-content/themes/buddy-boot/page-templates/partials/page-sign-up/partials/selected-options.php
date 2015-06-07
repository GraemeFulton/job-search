<!-- show user's selected options from on-boarding steps -->
<p>Your Profession(s):

    <?php
    if(isset($_GET['Profession'])) {
        foreach ($_GET["Profession"] as $selected_profession) {

            ?>
            <span class='selected'><?php echo ucfirst(str_replace("-jobs","",$selected_profession));?></span>

        <?php

        }
    }
    else echo "none";

    ?>
</p>

<p>Your Location(s):

    <?php
    if(isset($_GET['Location'])){
        foreach ($_GET["Location"] as $selected_location){

        ?>
        <span class='selected'><?php echo $selected_location;?></span>
        <?php

        }
    }
    else echo 'none';
?>
    </p>

