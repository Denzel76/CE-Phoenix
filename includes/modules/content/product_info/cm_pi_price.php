<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2018 osCommerce

  Released under the GNU General Public License
*/

  class cm_pi_price {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_PI_PRICE_TITLE;
      $this->description = MODULE_CONTENT_PI_PRICE_DESCRIPTION;
      $this->description .= '<div class="secWarning">' . MODULE_CONTENT_BOOTSTRAP_ROW_DESCRIPTION . '</div>';

      if ( defined('MODULE_CONTENT_PI_PRICE_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_PI_PRICE_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_PI_PRICE_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $product_info, $currencies;
      
      $content_width = (int)MODULE_CONTENT_PI_PRICE_CONTENT_WIDTH;
      
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
      $specials_price = null;
      
      if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
        $specials_price = $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id']));
      }

      ob_start();
      include('includes/modules/content/' . $this->group . '/templates/cm_pi_price.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_PI_PRICE_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Price Module', 'MODULE_CONTENT_PI_PRICE_STATUS', 'True', 'Should this module be shown on the product info page?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Width', 'MODULE_CONTENT_PI_PRICE_CONTENT_WIDTH', '3', 'What width container should the content be shown in?', '6', '1', 'tep_cfg_select_option(array(\'12\', \'11\', \'10\', \'9\', \'8\', \'7\', \'6\', \'5\', \'4\', \'3\', \'2\', \'1\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_PI_PRICE_SORT_ORDER', '50', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_PI_PRICE_STATUS', 'MODULE_CONTENT_PI_PRICE_CONTENT_WIDTH', 'MODULE_CONTENT_PI_PRICE_SORT_ORDER');
    }
  }
  