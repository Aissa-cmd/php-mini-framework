<?php

class Response {
  private $templates_base_dir;

  public function set_template_base_dir(string $dir) {
    $this->templates_base_dir = $dir;
  }

  public function redirect($path) {
    header("location: $path");
  }

  public function render_template($request, $template, $context = []) {
    if(!file_exists("$this->templates_base_dir"."$template")) {
      throw new Exception("Templat not found");
    }
    extract($context);
    include_once "$this->templates_base_dir"."$template";
  }
}


