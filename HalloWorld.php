<?php
/******************
 *  variable Extension - this extension is an QBox extention
 *  Copyright (C) 2016 qbox4u.com <qbox4u@gmail.com>
 *
 *  This program is not free software therefore you can-not redistribute 
 *  it and/or modify it under the terms of the GNU General Public License 
 *  as published by the Free Software Foundation; either version 2 of the 
 *  License, or (at your option) any later version.
 *
 *  Please consult and/or request the administrator of QBox4u 
 *  to use the information and samples
 *  To copy the data an written autorisation of the developer as stated in 
 *  the $wgExtensionCredits is required 
 * 
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *  http://www.gnu.org/copyleft/gpl.html
 *
 *  To activate this extension, add the following into your LocalSettings.php file:
 *  require_once( "$IP/extensions/HalloWorld/HalloWorld.php");
 *
 *  Create an Mediawiki page and add the following 2 lines 
 *  <TAG1 arg1="xxx" arg2="xxx">Hallo world</TAG1>
 *  {{#FUNCTION1:Hallo|World}}
 *
 *  @ingroup Extensions
 *  @author Jan boer <qbox4u@gmail.com>
 *  @version 1.0
 *  @link http://QBox4u.com
 *
 */
/******************
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) )  {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.<br>\n" );
	echo( "Use this php file only locally on the QNAP TS-459 proII server  <br>\n" );
	echo( "****************************   WARNING  WARNING  WARNING ******************************<br>\n" );
	echo( "This is an restricted application only for testing purposes inside your Qbox4u server<br>\n" ); 
	die( -1 );
}

/**
 * Replace 'other'  in $wfExtensionCredits['other'][] before you publish by one of the following official names:
 *
 * 'specialpage'—reserved for additions to MediaWiki Special Pages;
 * 'parserhook' —used if your extension modifies, complements, or replaces the parser functions in MediaWiki;
 * 'variable'   —extension that add multiple functionality to MediaWiki;
 * 'other'      —all other extensions.
 * 
 * Extension credits that will show up on 
 *       Special : Version  
 *       subject : other
 * 
 * The extension data is available in an wiki at the page [[Special:Version]]
 **/  

$wfExtensionCredits['other'][] = array(
    'path'           => __FILE__,
	'name'           => 'QBox4u_HalloWorld',
	'version'        => '1.0',
	'author'         => array( 'https://www.linkedin.com/in/jan-boer-a24640113','qbox4u@gmail.com', 'your name' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension_talk:ProtectText',
	'description'    => 'This extension is my first extension you have created'
);

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wf_QBox4u_ParserFunction_Setup'; } 
       else { $wgExtensionFunctions[] = 'wf_QBox4u_ParserFunction_Setup'; }
 
function wf_QBox4u_ParserFunction_Setup( &$parser ) {

		// set the hook <TAG1> Hallo World </TAG1>
		$parser->setHook( 'TAG1', 'wf_QBox4u_TagFunctionRender' );
		// set the hook {{#MyFirsthook:Hallo|World}}
		$parser->setFunctionHook( 'FUNCTION1', 'wf_QBox4u_ParserFunction_Render' );
      return true;
}

$wgHooks['LanguageGetMagic'][]       = 'wf_QBox4u_First_Example_Magic';

function wf_QBox4u_First_Example_Magic( &$magicWords, $langCode ) {
		// Identify the hook {{#MyFirsthook:xxxxxxxxx}}
        $magicWords['FUNCTION1'] = array( 0, 'FUNCTION1' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

/**************************************************************************************
 ************  MAIN WIKI TAG {{#MyFirsthook:Hallo:World}} application   ***************
 **************************************************************************************
 *
 * The parser function itself for the hook 
 * The input parameters are wikitext with templates expanded
 *
 **************************************************************************************
 *
 * Function: 	wf_QBox4u_ParserFunction_Render( &$parser)
 *
 * NOTES:		The input parameters are wikitext with templates expanded
 *
 * Purpose : 	Operational part of the extention hook in your wiki
 *
 * Input   : 	#QNAP_First_hook:parameter1|parameter2|parameter3|parameter4|parameter5
 *           
 * Output  : 	parameter1|parameter2|parameter3|parameter4|parameter5
 *
 * 
 */
function wf_QBox4u_TagFunctionRender( $input, array $args, Parser $parser, PPFrame $frame  ) {
	$attr = array();
    
    # first of all, retrieve the parameters that we have in the hook
	foreach( $args as $name => $value )
		$attr[] = '<strong>' . htmlspecialchars( $name ) . '</strong> = ' . htmlspecialchars( $value );
	
	$html_body  = "<strong>My first TAG function</strong><br>\n";
	$html_body .= "---- \n";
	$html_body .= "This is my  first typical syntax for a TAG function <strong>&lt;Tag1 arg1='xxx' arg2='xxx'&gt; my data &lt;/Tag1&gt;</strong><br />\n";	
	$html_body .= 'my Tag hook contains '.count($args)." elements<br>\n";
	$html_body .= '$attributes[0] '.$attr[0]."<br>\n";
	$html_body .= '$attributes[1] '.$attr[1]."<br>\n";
	$html_body .= ' The data between 2 TAGS is:'.htmlspecialchars( $input )."\n";

/*
From here you can create your own PHP Appication 
You only need to remember that the additional data you like to dispay resides inside $html_body 
*/
	$output = $parser->recursiveTagParse( $html_body, $frame );
	
  return array( $output, 'noparse' => false, 'isHTML' => false);

}

function wf_QBox4u_ParserFunction_Render( &$parser  ){

  # first of all, retrieve the parameters that we have in the hook
  $arg = func_get_args();
  array_shift($arg); // 0th parameter is the $parser
  
	$html_body  = "<strong>My first Parser function</strong><br>\n";
	$html_body .= "---- \n";
	$html_body .= "This is my first typical syntax for a Parser function <strong><nowiki>{{#FUNCTION1: arg1 | arg2 }}</nowiki></strong><br>";
	$html_body .= 'my Parser hook contains '.count($arg)." elements<br />\n";
	$html_body .= '$attributes[0] <strong>'.($arg[0])."</strong><br>\n";
	$html_body .= '$attributes[1] <strong>'.($arg[1])."</strong><br>\n";
/*
From here you can create your own PHP Appication 
You only need to remember that the additional data you like to dispay resides inside $html_body 
*/	
	$output = $html_body;
	
  return array( $output, 'noparse' => false, 'isHTML' => false);
}

/**
 * Finalise the PHP
 *  
 **/
?>
