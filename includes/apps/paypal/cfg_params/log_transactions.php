<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_PayPal_Cfg_log_transactions {
    var $default = '1';
    var $sort_order = 500;

    function __construct() {
      global $OSCOM_PayPal;

      $this->title = $OSCOM_PayPal->getDef('cfg_log_transactions_title');
      $this->description = $OSCOM_PayPal->getDef('cfg_log_transactions_desc');
    }

    function getSetField() {
      global $OSCOM_PayPal;
      
      $input = null;      
      $input .= '<div class="custom-control custom-radio custom-control-inline">';
        $input .= '<input type="radio" class="custom-control-input" id="logTransactionsSelectionAll" name="log_transactions" value="1"' . (OSCOM_APP_PAYPAL_LOG_TRANSACTIONS == '1' ? ' checked="checked"' : '') . '>';
        $input .= '<label class="custom-control-label" for="logTransactionsSelectionAll">' . $OSCOM_PayPal->getDef('cfg_log_transactions_all') . '</label>';
      $input .= '</div>';
      $input .= '<div class="custom-control custom-radio custom-control-inline">';
        $input .= '<input type="radio" class="custom-control-input" id="logTransactionsSelectionErrors" name="log_transactions" value="0"' . (OSCOM_APP_PAYPAL_LOG_TRANSACTIONS == '0' ? ' checked="checked"' : '') . '>';
        $input .= '<label class="custom-control-label" for="logTransactionsSelectionErrors">' . $OSCOM_PayPal->getDef('cfg_log_transactions_errors') . '</label>';
      $input .= '</div>';
      $input .= '<div class="custom-control custom-radio custom-control-inline">';
        $input .= '<input type="radio" class="custom-control-input" id="logTransactionsSelectionDisabled" name="log_transactions" value="-1"' . (OSCOM_APP_PAYPAL_LOG_TRANSACTIONS == '-1' ? ' checked="checked"' : '') . '>';
        $input .= '<label class="custom-control-label" for="logTransactionsSelectionDisabled">' . $OSCOM_PayPal->getDef('cfg_log_transactions_disabled') . '</label>';
      $input .= '</div>';

      $result = <<<EOT
<h5>{$this->title}</h5>
<p>{$this->description}</p>

<div id="logSelection">{$input}</div>
EOT;

      return $result;
    }
  }
?>
