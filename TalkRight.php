<?php
/**
 * Talkright MediaWiki extension
 * @author Marc Noirot - marc dot noirot at gmail
 * @author P.Levêque - User:Phillev
 * @author James Montalvo - User:Jamesmontalvo3
 *
 * This extension makes the editing of talk pages a distinct action from
 * the editing of articles, to create finer permissions by adding the 'talk' right.
 *
*/
 
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install the TalkRight extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/TalkRight/TalkRight.php" );
EOT;
    exit( 1 );
}
 
$wgExtensionCredits['other'][] = array(
    'name' => 'TalkRight',
    'version' => '1.4.1',
    'author' => array('P.Lev&ecirc;que', 'Marc Noirot', 'James Montalvo'),
    'description' => 'Adds a <tt>talk</tt> permission independent from article edition',
    'url' => 'http://www.mediawiki.org/wiki/Extension:Talkright',
);
 
# Register hooks
$wgHooks['AlternateEdit'][] = 'TalkRight::alternateEdit';
$wgHooks['ParserBeforeStrip'][] = 'TalkRight::giveEditRightsWhenViewingTalkPages';

# Global 'talk' right
$wgAvailableRights[] = 'talk';
 
class TalkRight {

    /**
     * Bypass edit restriction when EDITING pages if user has 'talk' right and page is a talk (discussion) page.
     * @param $&editPage the page edition object
     * @return true to resume edition to normal operation
     */
    static function alternateEdit( $editPage ) {
        global $wgOut, $wgUser, $wgRequest, $wgTitle;
        if ( $wgTitle->isTalkPage() && $wgUser->isAllowed( 'talk' ) ) {
            array_push( $wgUser->mRights, 'edit' );
        }
        return true;
    }

    /**
     * Bypass edit restriction when VIEWING pages if user has 'talk' right and page is a talk (discussion) page.
	 * This is probably not the ideal hook to use. I just needed one earlier than creation of section links, edit tab and add topic tab
     * @param &$parser parser object, used to gain access to User and Title objects
	 * @param &$text unused
	 * @param &$strip_state unused
     * @return true and false both seemed to work. [[Manual:Hooks/ParserBeforeStrip]] doesn't indicate what return value affects
     */    
    static function giveEditRightsWhenViewingTalkPages ( &$parser, &$test, &$test ) {
        
        $user = $parser->getUser();
        if ( $parser->getTitle()->isTalkPage() && $user->isAllowed( 'talk' ) ) {
            array_push( $user->mRights, 'edit' );            
        }
        
        return true;
    }
    
}