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


/**
 * Avoid unstubbing $wgParser too early on modern (1.12+) MW versions, as per r35980
 * Define a setup function
 *
 **/
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wf_QBox4u_ParserFunction_Setup';
   } 
     else {
	 $wgExtensionFunctions[] = 'wf_QBox4u_ParserFunction_Setup';
     }
 
function wf_QBox4u_ParserFunction_Setup( &$Parser ) {

        # Set a function hook associating the 'First_hook' magic word with our function 
	$Parser->setFunctionHook( 'MyFirsthook', 'wf_QBox4u_ParserFunction_Render' );
	return true;
}

/**
 * Add a hook to initialise the magic word
 *
 **/
$wgHooks['LanguageGetMagic'][]       = 'wf_QNAP_First_Example_Magic';


/**
 * Add the magic word
 * The first array element is whether to be case sensitive
 *  in this case 
 *   0 it is not case sensitive, 
 *   1 would be sensitive
 * All remaining elements are synonyms for our parser function
 *
 **/
function wf_QNAP_First_Example_Magic( &$magicWords, $langCode ) {

        $magicWords['MyFirsthook'] = array( 0, 'MyFirsthook' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

/**************************************************************************************
 ******************   	  MAIN WIKI TAG <First_hook> application 		***************
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
 * Input   : 	#QNAP_First_hook:parameter1|parameter2
 *           
 * Output  : 	parameter1|parameter2
 *
 * 
 */
function wf_QBox4u_ParserFunction_Render( &$parser){

  # first of all, retrieve the parameters that we have in the hook
  $attributes = func_get_args();
  array_shift($attributes); // 0th parameter is the $parser
  $html_body  = 'my hook contains '.count($attributes).' elements<br>';
  $html_body .= '$attributes[0] '.($attributes[0]).'<br>';
  $html_body .= '$attributes[1] '.($attributes[1]).'<br>';
  

  
  $html_body .= ' Congratuations, you suceeded in creating your first extension';
  
  return array( $html_body, 'noparse' => false, 'isHTML' => false);
}

/**
 * Finalise the PHP
 *  
 **/
?>
