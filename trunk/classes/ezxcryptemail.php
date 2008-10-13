<?php

class ezxcryptemail
{
    function ezxcryptemail()
    {

    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'cryptemail' );
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }    
 
    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'cryptemail' => array( ) );

    }
    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        $regex = ezxcryptemail::regexEmail() ;

        $regexlink = "/<a.*\s*href=[\\\"\\']mailto:($regex)[\\\"\\']\s*.*>(.*)<\/a>/U";
        $operatorValue = preg_replace_callback(
           $regexlink,
           array('ezxcryptemail', 'processMatches2'),
           $operatorValue );

        $operatorValue = preg_replace_callback(
           "/". $regex ."/",
           array('ezxcryptemail', 'processMatches'),
           $operatorValue );
    }

    static function processMatches2($matches)
    {
        return ezxcryptemail::crypt_mailto( $matches[1], $matches[2] );
    }

    static function processMatches($matches)
    {
        return ezxcryptemail::crypt_mailto( $matches[0], $matches[0] );
    }

    static function regexEmail() {
        // RegEx begin
        $nonascii      = "\x80-\xff"; # Non-ASCII-Chars are not allowed

        $nqtext        = "[^\\\\$nonascii\015\012\"]";
        $qchar         = "\\\\[^$nonascii]";

        $protocol      = '(?:mailto:)';

        $normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
        $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
        $user_part     = "(?:$normuser|$quotedstring)";

        $dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9._-]*\\.';
        $dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*';
        $dom_tldpart   = '[a-zA-Z]{2,5}';
        $domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";
        
        $regex         = "$user_part\@$domain_part";
        #$regex         = "$protocol?$user_part\@$domain_part";
        // RegEx end

        return $regex;
    }

    static function crypt_mailto( $MC_address, $MC_text, $MC_icon = false, $MC_noscript = false ) {

                    // e-mail address:
                    // link text:
                    // icon (custom icon displayed)
                    // noscript: paranoid (off) or page link



                // populate JS vars...
                    // scramble e-mail address
                    $nospamplease = '';
                    for($i = 0; $i < strlen($MC_address); $i++) {
                        $nospamplease .= ord(substr($MC_address, $i, $i + 1)) - 23;
                    }

                    // link text
                    $idontlikespam = $MC_text;

                    // icons...
                    if( $MC_icon ) 
                    {
                        $nothanks = $MC_icon;
                        if( file_exists( $MC_icon ) ) {
                            $size = GetImageSize( $MC_icon );
                            $no = $MC_icon_w = $size[0];
                            $way = $MC_icon_h = $size[1];
                        } else {
                            $MC_icon = '';
                            $nothanks = '';
                            $no = '';
                            $way = '';
                        }
                    }
                    else {
                        $nothanks = '';
                        $no = '';
                        $way = '';
                    }
                    $regex = ezxcryptemail::regexEmail();
                    if ( preg_match( "/$regex/", $idontlikespam ) )
                    {
                        $ini = eZINI::instance( 'template.ini' );
                        $dotText = $ini->variable( 'WashSettings', 'EmailDotText' );
                        $atText = $ini->variable( 'WashSettings', 'EmailAtText' );
                        $idontlikespam = str_replace( array( '.',
                                                     '@' ),
                                              array( $dotText,
                                                     $atText ),
                                              $idontlikespam );
                    }
                    
                    $crypt = '';
                    $uid = uniqid( "cryptemail_" );
                    // build JS code
                    $crypt .= '<a id="'.$uid.'" href="'.$nospamplease.'">'.$idontlikespam.'</a><script type="text/javascript" ><!--//--><![CDATA[//><!-- '."\n";
                    $crypt .= "showmail( '".$uid."' )"."\n";
                    $crypt .= '//--><!]]></script>';

        return $crypt;

    }

}
?>
