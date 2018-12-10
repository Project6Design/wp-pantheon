<?php
/**
 * Base class for all post types.
 */

namespace Project6\PostTypes;

abstract class BasePostType
{
  abstract public function register();
  abstract public function index();
  abstract public function view();

  public function shortcodes()
  {
    return [];
  }

  public function imageSizes()
  {
    return [];
  }
}
