<?php
/**
 * Plugin Name: ar-flickr
 * Plugin URI: http://flickr.andresroget.com
 * Description: Simple and Easy flickr feed.
 * Version: 1.0.0
 * Author: Andres Roget
 * Author URI: http://andresroget.com
 * License:GPL2
 */

 // we load our plugin's JS here
  function flickr_load_js(){
    wp_enqueue_script( 'main', plugins_url( 'main.js', __FILE__ ), array('jquery') );
    wp_enqueue_script( 'moment', plugins_url( 'moment.js', __FILE__ ), array('jquery') );

    // passing php variables to our scripts file
    $opt = get_option('widget_ar_flickr');

    $values = array();
    foreach($opt as $key => $value){
     $values[] = $value;
    }

    $apikey = $values[0]['flickrApikey'];
    $userName = $values[0]['flickrUsername'];
    $photos = $values[0]['flickrPhotos'];

    $flickrApikey    =  $apikey;
    $flickrUsername  =  $userName;
    $flickrPhotos    =  $photos;

    wp_localize_script('main', 'setting', array(
      'api' => $flickrApikey,
      'username' => $flickrUsername,
      'photos' => $flickrPhotos
		  )
	  );
  }
  add_action('wp_enqueue_scripts', 'flickr_load_js');


 // we defined the widget here
 class ar_flickr extends WP_Widget {

 // constructor
 function ar_flickr() {
   parent::WP_Widget(false, $name = __('AR Flickr', 'ar_flickr_plugin') );
 }

 // widget form creation
  function form($instance) {

  // Check values
  if( $instance) {
      $flickrApikey = esc_attr($instance['flickrApikey']);
      $flickrUsername = esc_attr($instance['flickrUsername']);
      $flickrPhotos = esc_textarea($instance['flickrPhotos']);
  } else {
      $flickrApikey = '';
      $flickrUsername = '';
      $flickrPhotos = '';
  }
  ?>
  <p>
  <label for="<?php echo $this->get_field_id('flickrApikey'); ?>"><?php _e('Flickr API Key', 'ar_flickr_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('flickrApikey'); ?>" name="<?php echo $this->get_field_name('flickrApikey'); ?>" type="text" value="<?php echo $flickrApikey; ?>" />
  </p>

  <p>
  <label for="<?php echo $this->get_field_id('flickrUsername'); ?>"><?php _e('Flickr User Name', 'ar_flickr_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('flickrUsername'); ?>" name="<?php echo $this->get_field_name('flickrUsername'); ?>" type="text" value="<?php echo $flickrUsername; ?>" />
  </p>

  <p>
  <label for="<?php echo $this->get_field_id('flickrPhotos'); ?>"><?php _e('How Many Pictures?', 'ar_flickr_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('flickrPhotos'); ?>" name="<?php echo $this->get_field_name('flickrPhotos'); ?>" type="text" value="<?php echo $flickrPhotos; ?>" />
  </p>
  <?php
  }

	// update widget
  function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['flickrApikey'] = strip_tags($new_instance['flickrApikey']);
      $instance['flickrUsername'] = strip_tags($new_instance['flickrUsername']);
      $instance['flickrPhotos'] = strip_tags($new_instance['flickrPhotos']);
     return $instance;
   }

  // display widget
  function widget($args, $instance) {
   extract( $args );

   // these are the widget options
   $flickrApikey = apply_filters('widget_title', $instance['flickrApikey']);
   $flickrUsername = $instance['flickrUsername'];
   $flickrPhotos = $instance['flickrPhotos'];
   echo $before_widget;
   // Display the widget
   $opt = get_option('widget_ar_flickr');

   echo '<h3>Latest From flickr</h3>';
   echo '<div id="gallery">';
   echo '</div>';
   echo $after_widget;
  }
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("ar_flickr");'));

 ?>
