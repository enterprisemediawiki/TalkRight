<?php
/**
 * Main class for the Talkright MediaWiki extension
 * @author Marc Noirot - marc dot noirot at gmail
 * @author P.Levêque - User:Phillev
 * @author James Montalvo - User:Jamesmontalvo3
 *
 *
*/
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