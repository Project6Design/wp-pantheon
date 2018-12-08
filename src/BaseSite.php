<?php

use Project6\PostTypes\BasePostType;

abstract class BaseSite extends TimberSite
{
  protected $postTypes = [];

  public function __construct()
  {
    // add_filter('timber_context', [$this, 'addToContext']);
    // add_filter('get_twig', [$this, 'addToTwig']);
    // add_filter('login_headerurl', [$this, 'logoUrl']);
    // add_filter('default_hidden_meta_boxes', [$this, 'hideMetaBox'], 10, 2);
    // add_filter('wp_insert_post_data', [$this, 'updatePersonTitle'], '99', 2);

    // add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
    // add_action('init', [$this, 'removeRoles']);
    // add_action('init', [$this, 'editorStyles']);
    // add_action('login_head', [$this, 'loginStylesheet']);
    // add_action('admin_menu', [$this, 'hideDefaultPostType']);

    // // Add ACF options page.
    // acf_add_options_page();

    // $this->registerPostTypes();
    // $this->addShortCodes();
    // $this->addImageSizes();
    // $this->routes();

    parent::__construct();
  }

  public function init()
  {
    $this->registerPostTypes();
  }


  public function addPostType(BasePostType $postType)
  {
    array_push($this->postTypes, $postType);
  }

  public function registerPostTypes()
  {
    if (count($this->postTypes)) {
      foreach ($this->postTypes as $postType) {
        add_action('init', [$postType, 'register']);
      }
    }
  }
}
