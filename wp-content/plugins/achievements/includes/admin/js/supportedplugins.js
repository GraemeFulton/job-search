/*! http://wordpress.org/plugins/achievements/ */
!function(a){function b(b){b.preventDefault(),b.stopImmediatePropagation();var c=a("#dpa-toolbar-filter").val(),d=a("#dpa-toolbar-search").val(),e=null,f="",g=a("#post-body-content > div").prop("class");if(g.indexOf("grid")>=0)g="grid",f="#post-body-content > .grid a";else if(g.indexOf("list")>=0)g="list",f="#post-body-content > .list tbody tr";else if(g.indexOf("detail")>=0)return;a(f).each(function(){e=a(this),"1"===c?e.hasClass("installed")?e.addClass("showme"):e.addClass("hideme"):"0"===c?e.hasClass("notinstalled")?e.addClass("showme"):e.addClass("hideme"):e.addClass("showme")}),a(f+":not(.hideme)").each(function(){e=a(this),("grid"===g&&e.children("img").prop("alt").search(new RegExp(d,"i"))<0||"list"===g&&e.children(".name").text().search(new RegExp(d,"i"))<0||"detail"===g&&e.prop("class").search(new RegExp(d,"i"))<0)&&(e.removeClass("showme"),e.addClass("hideme"))}),a(f).each(function(){e=a(this),e.hasClass("showme")?e.show():e.hasClass("hideme")&&e.hide(),e.removeClass("hideme").removeClass("showme")})}a(document).ready(function(){a("#dpa-toolbar").submit(function(b){b.stopPropagation(),b.preventDefault(),1===a("#post-body-content > .grid a:visible").size()?window.location=a("#post-body-content > .grid a:visible").prop("href"):1===a("#post-body-content > .list tbody tr:visible").size()&&(window.location=a("#post-body-content > .list tbody tr:visible .plugin a").prop("href"))}),a("#dpa-details-plugins").on("change.achievements",function(){window.location.search="post_type=achievement&page=achievements-plugins&filter=all&view=detail&plugin="+a(this.options[this.selectedIndex]).data("plugin")}),a("#dpa-toolbar-filter").on("change.achievements",b),a("#dpa-toolbar-search").on("keyup.achievements",b),a("#post-body-content .list table").tablesorter({headers:{0:{sorter:!1},1:{sorter:!1},3:{sorter:!1}},textExtraction:function(a){return a.innerHTML}}),a("#post-body-content .list table th").on("click.achievements","a",function(a){a.preventDefault()}),Socialite.load(a("#dpa-detail-contents h3"))})}(jQuery);