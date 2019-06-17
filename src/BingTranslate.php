<?php

namespace Renziito;

/**
 * BingTranslate.class.php
 *
 * Class to connect with Bing Translator for free.
 *
 * @package PHP Bing Translate Wrapper;
 * @category Translation
 * @author Renziito <sepia.aki@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License 3.0
 * @version 1.0
 */

/**
 * Main class BingTranslate
 *
 * @package BingTranslate
 *
 */
class BingTranslate {

  const IG        = "2321DDC78DFB4DE9B092DCA60C56D267";
  const IID       = "translator.5035.7";
  const URL       = "https://www.bing.com/";
  const DETECT    = "tdetect";
  const TRANSLATE = "ttranslate";
  const AGENT     = "AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1";

  private $text;
  private $source;
  private $target;
  private $url;
  private $curl;

  function getText() {
    return $this->text;
  }

  function getSource() {
    return $this->source;
  }

  function getTarget() {
    return $this->target;
  }

  function getUrl() {
    return $this->url;
  }

  function getCurl() {
    return $this->curl;
  }

  function setText($text) {
    $this->text = $text;
  }

  function setSource($source) {
    $this->source = $source;
  }

  function setTarget($target) {
    $this->target = $target;
  }

  function setUrl($url) {
    $this->url = $url;
  }

  function setCurl($curl) {
    $this->curl = $curl;
  }

  function __construct() {
    $url = self::URL . self::TRANSLATE . '?IG=' . self::IG . '&IID=' . self::IID;
    $this->setUrl($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, self::AGENT);
    $this->setCurl($ch);
  }

  /**
   * Retrieves the translation of a text
   *
   * @param string text Text that you want to translate
   * @param string $target Language to which you want to translate the text in format xx. For example: es, en, it, fr...
   * @param string $source Language from which you want to translate the text in format xx. For example: es, en, it, fr...
   *
   * @return string a simple string with the translation of the text in the target language
   */
  public function translate($text = null, $target = null, $source = null) {
    if (is_null($source)) {
      $source = $this->detectLanguage($text);
    }
    $this->setText($text);
    $this->setTarget($target);
    $this->setSource($source);
    $this->validateParams();
    return $this->getTranslation();
  }

  private function getTranslation() {
    $params     = [
        'text' => $this->getText(),
        'from' => $this->getSource(),
        'to'   => $this->getTarget()
    ];
    $ch         = $this->getCurl();
    curl_setopt($ch, CURLOPT_URL, $this->getUrl());
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $jsonResult = curl_exec($ch);
    curl_close($ch);
    $result     = json_decode($jsonResult);
    if (!$result) {
      throw new \Exception("Bing no return dataset");
    }
    return $result->translationResponse;
  }

  private function detectLanguage($text) {
    $url    = self::URL . self::DETECT . '?IG=' . self::IG . '&IID=' . self::IID;
    $params = ['text' => $text];
    $ch     = $this->getCurl();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  private function validateParams() {
    if (is_null($this->getText())) {
      throw new \Exception("Text was not givin");
    }
    if (is_null($this->getTarget())) {
      throw new \Exception("Target was not givin");
    }
  }

}
