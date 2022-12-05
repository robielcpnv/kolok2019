<?php

  function deleteDir($path)
  {
    return !empty($path) && is_file($path) ?
      @unlink($path) :
      (array_reduce(glob($path.'/*'), function ($r, $i) { echo $r,$i; return $r && deleteDir($i); }, TRUE)) && @rmdir($path);
  }
