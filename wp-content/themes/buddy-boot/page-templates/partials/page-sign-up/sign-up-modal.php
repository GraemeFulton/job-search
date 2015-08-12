                <!-- Popup modal (custom header image) -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-body text-center">
                        <h4>Sign up for free</h4>
                        <p>Members get full access and will never be charged a penny</p>

          <div class='welcome-profile'>
                <!--<div class="panel panel-default flex-col">-->
                <div class='avatar-circle'>
                <?php  echo get_avatar( '', $size = '60' );?>
                </div>
                    <?php include('partials/selected-options.php');?>           </p>
               <div class="refine">
       <!--SOCIAL MEDIA-->
                            <div class="register-pg-social">
                                <button class='btn-success btn-outlined btn'>Sign in with email</button>
                                <br>
                                <button class='btn btn-large btn-fb'><a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">Sign in with facebook</a></button>
                                <br>
                                <button class='btn btn-large btn-twitter'><a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">Sign in with twitter</a></button>
                            </div>               </div>
            </div>
            </div>
                  </div>
              </div>
            </div>
        </div>
        <!-------------------------------------->



<!-- Modal -->
<div class="modal fade" id="redirectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">We are forwarding you to the job post site.</h4>
        <i class="fa fa-spinner fa-4x"></i>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>