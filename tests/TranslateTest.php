<?php

require_once ('vendor/autoload.php');
// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase')) {
  class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

use Renziito\BingTranslate;

class TranslateTest extends \PHPUnit\Framework\TestCase {

  public function testTranslate() {
    $source = 'es';
    $target = 'en';
    $text   = 'falso';
    $trans  = new BingTranslate();
    $result = $trans->translate($text, $target, $source);
    $this->assertEquals($result, 'False');
  }

}
