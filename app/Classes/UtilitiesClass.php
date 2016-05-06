<?php

namespace App\Classes;

class UtilitiesClass {   
    public static function urlencode_rfc3986($input) {
    if (is_array($input)) {
      return array_map(array(__CLASS__, 'urlencode_rfc3986'), $input);
    } else if (is_scalar($input)) {
      return str_replace(
        '+',
        ' ',
        str_replace('%7E', '~', rawurlencode($input))
      );
    } else {
      return '';
    }
  }
}