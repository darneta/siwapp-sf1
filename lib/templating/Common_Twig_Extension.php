<?php
sfContext::getInstance()->getConfiguration()->loadHelpers(array('Date', 'Text', 'Number'));

class Common_Twig_Extension extends Twig_Extension
{
  public function getFilters()
  {
    return array(
      // DateHelper
      'date'        => new Twig_Filter_Function('format_date'),
      'datetime'    => new Twig_Filter_Function('format_datetime'),
      // TextHelper
      'format'      => new Twig_Filter_Function('simple_format_text', array('pre_escape' => 'html', 'is_safe' => array('html'))),
      'unlink'      => new Twig_Filter_Function('strip_links_text'),
      'nl2br'       => new Twig_Filter_Function('nl2br', array('pre_escape' => 'html', 'is_safe' => array('html'))),
      // NumberHelper
      'currency'    => new Twig_Filter_Function('common_twig_extension_format_currency'),
      'round'       => new Twig_Filter_Function('common_twig_extension_round'),
      'number'      => new Twig_Filter_Function('format_number'),
      // Other
      'count'       => new Twig_Filter_Function('count'),
      'unhttp'      => new Twig_Filter_Function('common_twig_extension_unhttp'),
      'product_reference' => new Twig_Filter_Function('product_reference'),
      'split'       => new Twig_Filter_Function('twig_split_filter', array('needs_environment' => 'true')),
      'first'       =>  new Twig_Filter_Function('first', 'twig_first', array('needs_environment' => true)),
      'last'        =>  new Twig_Filter_Function('last', 'twig_last', array('needs_environment' => true)),
    );
  }
  
  public function getName()
  {
    return 'common';
  }
}

function common_twig_extension_format_currency($amount, $culture = null)
{
  $currency = sfContext::getInstance()->getUser()->getCurrency();
  return format_currency($amount, $currency, $culture);
}

function common_twig_extension_round($amount, $decimals = 2)
{
  return round($amount, $decimals);
}

function common_twig_extension_unhttp($url)
{
  return str_replace(array('http://', 'https://'), null, $url);
}

function product_reference($product_id){
    return Doctrine::getTable("Product")->getReference($product_id);
}

function twig_split_filter(Twig_Environment $env, $value, $delimiter, $limit = null)
{
  if (!empty($delimiter)) {
    return null === $limit ? explode($delimiter, $value) : explode($delimiter, $value, $limit);
  }
  if (!function_exists('mb_get_info') || null === $charset = $env->getCharset()) {
    return str_split($value, null === $limit ? 1 : $limit);
  }
  if ($limit <= 1) {
    return preg_split('/(?<!^)(?!$)/u', $value);
  }
  $length = mb_strlen($value, $charset);
  if ($length < $limit) {
    return array($value);
  }
  $r = array();
  for ($i = 0; $i < $length; $i += $limit) {
    $r[] = mb_substr($value, $i, $limit, $charset);
  }
  return $r;
}

function twig_first(Twig_Environment $env, $item)
{
  $elements = twig_slice($env, $item, 0, 1, false);
  return is_string($elements) ? $elements : current($elements);
}

function twig_last(Twig_Environment $env, $item)
{
  $elements = twig_slice($env, $item, -1, 1, false);
  return is_string($elements) ? $elements : current($elements);
}