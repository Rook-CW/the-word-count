<?php

/*
Plugin Name: The Word Count - number of Character -
Plugin URI: http://crowworks.net/
Description:
Version: 1.0
Author: Rook
Author URI: http://crowworks.net/
License: GPL2
*/

class TheWordCount {

  function init() {
    if (is_admin()) {
      add_filter("manage_posts_columns", array(&$this, "columns"));
      add_action("manage_posts_custom_column", array(&$this, "custom_column"));
    }
  }

  function count_word($html) {
    $text = strip_tags($html);
    // $text = preg_replace('/<!--[\s\S]*?-->/', '', $text);//Regular expression to find HTML comments.
    $text = preg_replace('/\\[\\/?(?:)[^\\]]*?\\]/', '', $text);//Regular expression to shortcode.

    $text = preg_replace('/&\S+?;/', ' ', $text);//Regular expression to find HTML entities.
    $text = preg_replace('/\s\s+/', '', $text);//Regular expression to find irregular space characters.

    return mb_strlen($text);
  }

  function columns($columns) {
    $columns["the_word_count"] = "Word Count";
    return $columns;
  }

  function custom_column($column) {
    global $post;
    if ("the_word_count" == $column) {
      $word_count = $this->count_word($post->post_content);
      echo $word_count;
    }
  }

}

$theWordCount = new TheWordCount();
$theWordCount->init();
