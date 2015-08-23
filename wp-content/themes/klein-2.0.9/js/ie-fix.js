/**
 * Support for IE quirks
 *
 * @package klein
 */
 
/*
 * Support javascript trim method 
 * b'Cuz BuddyPress uses a lot .trim() method and 
 * the great great IE8 doesnt support it
 */
if(typeof String.prototype.trim !== 'function') {
  String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, ''); 
  }
}