<?php

// Operator autoloading

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] =
  array( 'script' => 'extension/cryptemail/classes/ezxcryptemail.php',
         'class' => 'ezxcryptemail',
         'operator_names' => array( 'cryptemail' ) );

?>
