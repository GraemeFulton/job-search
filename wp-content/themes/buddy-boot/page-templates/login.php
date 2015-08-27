<?php
/*
 * Template Name: Log \in
 *
 * A Page for courses
*/
?>

<?php get_header(); ?>

    <?php include(get_stylesheet_directory().'/partials/side-nav.php');?>
    <section class="col-md-9 main-content-area  col-md-offset-2  col-xs-12" style="margin-top:0px;">
      <h2><i class="material-icons">lock</i> Log In</h2>
    <div class="row custom-tax-single copy-card col-md-8 col-sm-8">

      <div class="register-pg-social" style="clear:both;">
         <a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">
                            <button class="btn btn-fb">Sign in with facebook<div class="ripple-wrapper"></div></button>
                     </a>
                     <br>
                     <a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">
                            <button class="btn btn-twitter">Sign in with twitter</button>
                     </a>
      </div>
      <hr>
        <div class="login-form">
        <?php
        global $user_login;
          if (is_user_logged_in()) {
              echo 'Hello, ', $user_login, '. <a href="', wp_logout_url(), '" title="Logout">Logout</a>';
          } else {
              wp_login_form();
          }

        ?>
        </div>


      </div>
      <br>

    </section>
<?php get_footer(); ?>

</body>
</html>
