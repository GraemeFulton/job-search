<style>
.title{
display:none;}
.alternate-reg .wpuf-el, .alternate-reg li{
list-style:none;
}
.register-pg-social a{
color:#fff;
}
.register-pg-social{
padding:0 8px 8px 8px;
}
h1{
margin-top:0px;
}
.container.post{
padding:25px;
}
</style>


<div class="container post">
<h1>Sign up</h1>
<p>Sign up with your social media accounts:</p>
<div class="register-pg-social">
<div class="new-fb-btn new-fb-4 new-fb-default-anim"><div class="new-fb-4-1"><div class="new-fb-4-1-1"><a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">Log In with facebook</a></div></div></div><div class="new-twitter-btn new-twitter-4 new-twitter-default-anim"><div class="new-twitter-4-1"><div class="new-twitter-4-1-1"><a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">Log In with twitter</a></div></div></div>
</div>
</div>
<div class="container post">

<div class="alternate-reg">
<p>Or Sign up with your email address below:</p>
[wpuf_profile type="registration" id="10323"]
</div>

<?php 
$arr_ser = StripSlashes($_COOKIE["profession"]);

$professions = unserialize($arr_ser);
var_dump ( $professions);

$arr_ser = StripSlashes($_COOKIE["location"]);

$professions = unserialize($arr_ser);
var_dump ( $professions);
?>



</div>