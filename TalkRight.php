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
    die( 'Invalid entry point.' );
}

# Extension credits
$GLOBALS['wgExtensionCredits']['other'][] = array(
    'name' => 'TalkRight',
    'version' => '1.5.0',
    'author' => array('P.Leveque', 'Marc Noirot', 'James Montalvo'),
    'description' => 'Adds a <tt>talk</tt> permission independent from article edition',
    'url' => 'http://www.mediawiki.org/wiki/Extension:Talkright',
);

# Register hooks
$GLOBALS['wgHooks']['AlternateEdit'][] = 'TalkRight::alternateEdit';
$GLOBALS['wgHooks']['ParserBeforeStrip'][] = 'TalkRight::giveEditRightsWhenViewingTalkPages';

# Autoload
$GLOBALS['wgAutoloadClasses']['TalkRight'] = __DIR__ . '/TalkRight.class.php';

# Global 'talk' right
$GLOBALS['wgAvailableRights'][] = 'talk';