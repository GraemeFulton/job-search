
<form class="form-inline" role="form"  action="<?php echo home_url( '/' ); ?>">
  <div class="input-field form-group has-success has-feedback">
    <label class="control-label" for="s"></label>
    <label for="s">Search</label>
    <input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" >
    <input type="hidden" name="post_type" value="graduate-job">
    <span class="fa fa-search form-control-feedback"></span>
  </div>
</form>
