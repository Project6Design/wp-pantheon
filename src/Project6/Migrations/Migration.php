<?php
/**
 * Base class for all migrations.
 */

namespace Project6\Migrations;

use Project6\PostTypes\PostType;

abstract class Migration
{
  protected $post_type;
  protected $posts_table;
  protected $meta_table;
  protected $stats;

  public function __construct(PostType $post_type)
  {
    global $wpdb;

    $this->posts_table = $wpdb->prefix . 'posts';
    $this->meta_table = $wpdb->prefix . 'postmeta';
    $this->post_type = $post_type;
    $this->stats = null;
  }

  /**
   * Import posts.
   */
  abstract public function import();


  /**
   * Get statistics for the last action.
   *
   * @return Proect6\Migration\Stats
   */
  public function getStats()
  {
    return $this->stats;
  }

  /**
   * Load CSV file into an array
   *
   * @return array CSV data.
   */
  public function loadCsvFile($file)
  {
    $data = [];

    if (file_exists($file)) {
      $data = array_map('str_getcsv', file($file));

      array_walk($data, function(&$row) use ($data) {
        $row = array_combine($data[0], $row);
      });

      array_shift($data);
    }

    return $data;
  }


  public function delete()
  {
    global $wpdb;

    // Get all post ids that have a source id.
    $query_delete = "SELECT post_id
        FROM {$this->meta_table} meta
        JOIN {$this->posts_table} posts ON posts.ID = meta.post_id
        WHERE posts.post_type = '{$this->post_type->label()}' AND meta.meta_key = 'source_id' AND meta.meta_value <> '' ";

    $pids = $wpdb->get_results($query_delete);

    if (count($pids)) {
      foreach ($pids as $rec) {
        wp_delete_post( $rec->post_id, true);
      }
    }

    $this->stats = new Stats();
    $this->stats->total = count($pids);
  }
}
