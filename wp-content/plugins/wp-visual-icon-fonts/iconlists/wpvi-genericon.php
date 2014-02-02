<?php

/* Create Icon List Array
- - - - - - - - - - - - - - - - - - - - - - - - - - */
function wpvi_icon_list() {
	$gen_icons = array( 'standard','aside','image','gallery','video','status','quote','link','chat','audio','github','dribbble','twitter','facebook','facebook-alt','wordpress','googleplus','linkedin','linkedin-alt','pinterest','pinterest-alt','flickr','vimeo','youtube','tumblr','instagram','codepen','polldaddy','googleplus-alt','path','skype','digg','reddit','stumbleupon','pocket','comment','category','tag','time','user','day','week','month','pinned','search','unzoom','zoom','show','hide','close','close-alt','trash','star','home','mail','edit','reply','feed','warning','share','attachment','location','checkmark','menu','refresh','minimize','maximize','404','spam','summary','cloud','key','dot','next','previous','expand','collapse','dropdown','dropdown-left','top','draggable','phone','send-to-phone','plugin','cloud-download','cloud-upload','external','document','book','cog','unapprove','cart','pause','stop','skip-back','skip-ahead','play','tablet','send-to-tablet','info','notice','help','fastforward','rewind','portfolio','heart','code','subscribe','unsubscribe','subscribed','reply-alt','reply-single','flag','print','lock','bold','italic','picture','uparrow','rightarrow','downarrow','leftarrow'
	);

	sort($gen_icons);
	return $gen_icons;
}

