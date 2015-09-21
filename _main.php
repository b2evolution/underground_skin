<?php
/**
 * This is the main template. It displays the blog.
 *
 * However this file is not meant to be called directly.
 * It is meant to be called automagically by b2evolution.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @copyright (c)2003-2006 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2005 by Jason EDGECOMBE.
 * Parts of this file are copyright (c)2004-2005 by Daniel HAHLER.
 *
 * @license http://b2evolution.net/about/license.html GNU General Public License (GPL)
 *
 * {@internal Open Source relicensing agreement:
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 *
 * Jason EDGECOMBE grants Francois PLANQUE the right to license
 * Jason EDGECOMBE's personal contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * Template name: Underground, for b2evolution 1.10.x, design by Two18 Media (www.two18.com)
 *
 * @version $Id: _main.php,v 1.116.2.13 2007/03/10 18:37:31 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );
skin_content_header();	// Sets charset!
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php locale_lang() ?>" lang="<?php locale_lang() ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php skin_content_meta(); /* Charset for static pages */ ?>
	<?php $Plugins->trigger_event( 'SkinBeginHtmlHead' ); ?>
	<title><?php
		$Blog->disp('name', 'htmlhead');
		request_title( ' - ', '', ' - ', 'htmlhead' );
	?>
	</title>
	<?php skin_base_tag(); /* To fix relative links! */ ?>
	<meta name="contributor" content="b2evo skin Underground - design by Andrew Hreschak (blog.thedarksighed.com)" />
	<meta name="rating" content="General" />
	<meta name="generator" content="b2evolution <?php echo $app_version ?>" />
	<link rel="alternate" type="text/xml" title="RSS 2.0" href="<?php $Blog->disp( 'rss2_url', 'raw' ) ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom" href="<?php $Blog->disp( 'atom_url', 'raw' ) ?>" />	
	<link href="underground.css" rel="stylesheet" type="text/css" media="screen" />
	<!--[if IE 5]>
	<style>
	body {text-align: center;}
	</style> 
	<![endif]-->
	<?php
		$Blog->disp( 'blog_css', 'raw');
		$Blog->disp( 'user_css', 'raw');
	?>
</head>
<body>
<div id="wrap">
	<?php	// This block calls custom skin icons from skin folder, if they exist there. Otherwise, they are called from the default icon folder
		$new_folder = $skins_subdir.$skin.'/img/';
		foreach( $map_iconfiles as $icon => $def )
		$map_iconfiles[ $icon ]['file'] = str_replace( $rsc_subdir, $new_folder, $def['file'] );
	?>
<div id="bannertop">
<div class="topicons"></div>
</div>
<div id="bannermid">
	<div class="subtitle"><h1><a href="<?php $Blog->disp( 'url', 'raw' ) ?>"><?php $Blog->disp( 'name', 'htmlbody' ) ?></a></h1><?php $Blog->disp( 'tagline', 'htmlbody' ) ?>
	</div>
</div>
<!-- =================================== START OF MAIN AREA =================================== -->
	<?php
		// ------------------------- TITLE FOR THE CURRENT REQUEST -------------------------
		// request_title( '<h2>', '</h2>' );
		// ------------------------------ END OF REQUEST TITLE -----------------------------
	?>
<div class="submenu">
	<?php
		// UNCOMMENT FOR MULTI-BLOG SYSTEMS
		// --------------------------- BLOG LIST INCLUDED HERE -----------------------------
		require dirname(__FILE__).'/_bloglist.php';
		// ------------------------------- END OF BLOG LIST --------------------------------
	?>
<!-- UNCOMMENT FOR SINGLE-BLOG SYSTEMS
	<h1><a href="<?php $Blog->disp( 'url', 'raw' ) ?>" title="View the main page of <?php $Blog->disp( 'name', 'htmlbody' ) ?>"><?php $Blog->disp( 'name', 'htmlbody' ) ?></a></h1>
	<?php $Blog->disp( 'tagline', 'htmlbody' ) ?>
-->
</div>
<div id="content">
<div class="leftside">
	<?php
		// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
		// if( empty( $preview ) ) $Messages->disp( );
		// --------------------------------- END OF MESSAGES ---------------------------------
	?>
<div class="text">
	<?php
		// ------------------------------------ START OF POSTS ----------------------------------------
		if( isset($MainList) ) $MainList->display_if_empty(); // Display message if no post

		if( isset($MainList) ) while( $Item = & $MainList->get_item() )
		{
	?>
	<?php
		//previous_post();	// link to previous post in single page mode
		//next_post(); 			// link to next post in single page mode
	?>
	<?php 
		echo T_('<h1>');
		$MainList->date_if_changed( '' , '' , 'd F Y' );
		echo T_('</h1>');
	?>
<div class="head">
<h2><a href="<?php $Item->permanent_url() ?>" title="<?php echo T_('Permanent link to full entry') ?>"><?php $Item->title( '', '', false ); ?></a></h2>
	<?php
		locale_temp_switch( $Item->locale ); // Temporarily switch to post locale
		$Item->anchor(); // Anchor for permalinks to refer to
	?>
<div class="bSmallHead">		
<div class="bSmallHeadMisc">
	<?php
		echo T_('Written by'), ' ';
		$Item->author( '<strong>', '</strong>' );
			$Item->msgform_link( $Blog->get('msgformurl'), ' ( ', ' )', '<img src="img/icons/envelope.gif" alt="Contact the author of this post" width="13" height="10" class="middle" />' );			
		echo '<br /> ';
		echo ' Published on ';
		$Item->issue_date('F jS, Y');
		echo ' @ ';
		$Item->issue_time();
		echo ', using ';
		$Item->wordcount();
		echo ' '.T_('words');
		echo ', ';
		$Item->views();
		// echo ' &nbsp; ';
		// locale_flag( $Item->locale, 'h10px' );
	?>	
</div>
<div class="bSmallHeadCats">
	<?php
		echo T_('Categories'), ': ';
		$Item->categories();
	?>
</div>
</div>
</div>
	<?php $Item->content(); ?>
	<?php link_pages() ?>
<div class="bSmallPrint">
	<?php 
		$Item->permanent_link( get_icon( 'permalink', 'imgtag' ).'Permanent Link', '#', 'permalink_right' );
		$Item->feedback_link( 'comments', '', '', '#', '#', '#', 'Display Comment / Leave a Comment' ); // Link to comments
		$Item->feedback_link( 'trackbacks', ' &nbsp; &nbsp; ' ); // Link to trackbacks
		$Item->edit_link( ' &nbsp;', '', get_icon( 'edit', 'imgtag' ).'Edit this article', 'Edit this article' ); // Link to backoffice for editing
		$Item->trackback_rdf(); // trackback autodiscovery info 
	?>
</div>
</div>
<div class="text"> 
	<?php
		// ------------- START OF INCLUDE FOR COMMENTS, TRACKBACK, PINGBACK, ETC. -------------
		$disp_comments = 1;					// Display the comments if requested
		$disp_comment_form = 1;			// Display the comments form if comments requested
		
		$disp_trackbacks = 1;				// Display the trackbacks if requested
		$disp_trackback_url = 0;		// Display the trackbal URL if trackbacks requested
		
		$disp_pingbacks = 1;				// Display the pingbacks if requested
		require( dirname(__FILE__).'/_feedback.php' );
		
		// -------------- END OF INCLUDE FOR COMMENTS, TRACKBACK, PINGBACK, ETC. --------------
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
	<?php
		} // ---------------------------------- END OF POSTS ------------------------------------
	?>
	<p class="center">
		<strong>
			<?php posts_nav_link(); ?>
			<?php
				// previous_post( '<p class="center">%</p>' );
				// next_post( '<p class="center">%</p>' );
			?>
		</strong>
	</p>
	<?php
		// -------------- START OF INCLUDES FOR LAST COMMENTS, MY PROFILE, ETC. --------------
		$current_skin_includes_path = dirname(__FILE__).'/';
		// Call the dispatcher:
		require $skins_path.'_dispatch.inc.php';
	?>
</div>
</div>
<!-- ============== SIDEBAR =============== -->
<div class="rightside">
<!-- =========== START SIDEITEM 1 ============ -->
<div class="righttext">
<script type="text/javascript">
  <!--
    var now = new Date();
    var days = new Array(
      'Sunday','Monday','Tuesday',
      'Wednesday','Thursday','Friday','Saturday');
    var months = new Array(
      'January','February','March','April','May',
      'June','July','August','September','October',
      'November','December');
    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
    function fourdigits(number)	{
      return (number < 1000) ? number + 1900 : number;}
    today =  days[now.getDay()] + ", " +
       date + " " +
       months[now.getMonth()] + " " +
       (fourdigits(now.getYear()));
     document.write(today);
  //-->
</script>
	<h3 class="blogname"><?php $Blog->disp( 'name', 'htmlbody' ) ?></h3>
		<?php $Blog->disp( 'longdesc', 'htmlbody' ); ?>
		<p class="center">
		<strong>
			<?php
				posts_nav_link( ' | ',
				/* TRANS: previous page (of posts) */ '< '.T_('Previous'),
				/* TRANS: next page (of posts) */ T_('Next').' >' );
			?>
		</strong>
		<br />
		</p>
</div>
<!-- ================= SEARCH  ================ -->
<div class="righttext">
		<?php form_formstart( $Blog->dget( 'blogurl', 'raw' ), 'search', 'SearchForm' ) ?>
		<p>
		<input type="text" name="s" size="20" value="<?php echo htmlspecialchars($s) ?>" class="SearchField" alt="Search"/>&nbsp;<input type="submit" name="submit" class="submit" value="<?php echo T_('Search') ?>" /><br />
		<input type="radio" name="sentence" value="AND" id="sentAND" <?php if( $sentence=='AND' ) echo 'checked="checked" ' ?>/><label for="sentAND"><?php echo T_('All') ?></label>
		&nbsp;
		<input type="radio" name="sentence" value="OR" id="sentOR" <?php if( $sentence=='OR' ) echo 'checked="checked" ' ?>/><label for="sentOR"><?php echo T_('Some') ?></label>
		&nbsp;
		<input type="radio" name="sentence" value="sentence" id="sentence" <?php if( $sentence=='sentence' ) echo 'checked="checked" ' ?>/><label for="sentence"><?php echo T_('Entire phrase') ?></label>
		</p>
		</form>
</div>
<!-- ============== CALENDAR =============== -->
	<?php
		// -------------------------- CALENDAR INCLUDED HERE -----------------------------
		$Plugins->call_by_code( 'evo_Calr', array(	// Params follow:
					'block_start'=>'',
					'block_end'=>'',
					'title'=>'',		// No title.
			) );
	?>
<!-- ============= CATEGORIES ============== -->
<div class="righttext">
	<?php
		// -------------------------- CATEGORIES INCLUDED HERE -----------------------------
		$Plugins->call_by_code( 'evo_Cats', array(	// Add parameters below:
			) );
	?>

	<ul>
		<li><a href="<?php $Blog->disp( 'staticurl', 'raw' ) ?>" title="<?php echo T_('View Most Recent Posts') ?>"><?php echo T_('Most Recent Posts') ?></a></li> 
		<li><a href="<?php $Blog->disp( 'lastcommentsurl', 'raw' ) ?>" title="<?php echo T_('View Latest comments') ?>"><?php echo T_('Latest comments') ?></a></li>
	</ul>
</div>
<!-- ============== ARCHIVES ============== -->
<div class="righttext">
	<?php
		// -------------------------- ARCHIVES INCLUDED HERE -----------------------------
		$Plugins->call_by_code( 'evo_Arch', array(	// Add parameters below:
			) );
	?>
</div>
<!-- ============== LINKBLOG ============= -->
<div class="righttext">
	<?php
		// -------------------------- LINKBLOG INCLUDED HERE -----------------------------
		require( dirname(__FILE__).'/_linkblog.php' );
	?>
</div>
<!-- ============== SKINLIST ============= -->
	<div class="righttext">
	<?php if( ! $Blog->get('force_skin') )
	{	// Skin switching is allowed for this blog: ?>
			<h3><?php echo T_('Select skin') ?></h3>
			<ul>
				<?php // ------------------------------- START OF SKIN LIST -------------------------------
				for( skin_list_start(); skin_list_next(); ) { ?>
					<li><a href="<?php skin_change_url() ?>"><?php skin_list_iteminfo( 'name', 'htmlbody' ) ?></a></li>
				<?php } // ------------------------------ END OF SKIN LIST ------------------------------ ?>
			</ul>
	<?php } ?>
	</div>
<!-- ================== MISC ================== -->
<div class="righttext">
	<h3><?php echo T_('Miscellany') ?></h3>
		<ul>
			<?php
				user_login_link( '<li>', '</li>' );
				user_register_link( '<li>', '</li>' );
				user_admin_link( '<li>', '</li>' );
				user_profile_link( '<li>', '</li>' );
				user_subs_link( '<li>', '</li>' );
				user_logout_link( '<li>', '</li>' );
			?>
		</ul>
</div>
<!-- ================= FEEDS AND EXTRAS ================== -->
<div class="righttext rss">
	<h3>XML Feeds</h3>
		<ul>
			<li>
				RSS 0.92:
				<a href="<?php $Blog->disp( 'rss_url', 'raw' ) ?>" title="Subscribe to RSS 0.92 Posts"><?php echo T_('Posts') ?></a>,
				<a href="<?php $Blog->disp( 'comments_rss_url', 'raw' ) ?>" title="Subscribe to RSS 0.92 Comments"><?php echo T_('Comments') ?></a>
			</li>
			<li>
				RSS 1.0:
				<a href="<?php $Blog->disp( 'rdf_url', 'raw' ) ?>" title="Subscribe to RSS 1.0 Posts"><?php echo T_('Posts') ?></a>,
				<a href="<?php $Blog->disp( 'comments_rdf_url', 'raw' ) ?>" title="Subscribe to RSS 1.0 Comments"><?php echo T_('Comments') ?></a>
			</li>
			<li>
				RSS 2.0:
				<a href="<?php $Blog->disp( 'rss2_url', 'raw' ) ?>" title="Subscribe to RSS 2.0 Posts"><?php echo T_('Posts') ?></a>,
				<a href="<?php $Blog->disp( 'comments_rss2_url', 'raw' ) ?>" title="Subscribe to RSS 2.0 Comments"><?php echo T_('Comments') ?></a>
			</li>
			<li>
				Atom:
				<a href="<?php $Blog->disp( 'atom_url', 'raw' ) ?>" title="Subscribe to Atom Posts"><?php echo T_('Posts') ?></a>,
				<a href="<?php $Blog->disp( 'comments_atom_url', 'raw' ) ?>" title="Subscribe to Atom Comments"><?php echo T_('Comments') ?></a>
			</li>
		</ul>
		<ul>
			<li>
				<a href="http://webreference.fr/2006/08/30/rss_atom_xml" title="RSS: Really Simple Syndication"><?php echo T_('What is RSS?') ?></a>
			</li>
		</ul>
	<h3>Users Currently Online</h3>
		<?php
			$Sessions->display_onliners();
		?>
	<h3>The Extras</h3>
		<ul class="clean">
			<li>
			This site uses <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Valid CSS 2.0">valid CSS 2.0</a>
			</li>
			<li>
			This site uses <a href="http://validator.w3.org/check?uri=referer" title="Valid XHTML" >valid XHTML</a>
			</li>
		</ul>
		<ul class="clean">
			<li>
				<a href="http://www.getfirefox.com" title="Get Firefox and rediscover the web!">Get Firefox</a> and rediscover the web! 
			</li>
		</ul>
</div>
<!-- ============ END FEEDS AND EXTRAS ============= -->
	<?php
	if( empty($generating_static) && ! $Plugins->trigger_event_first_true('CacheIsCollectingContent') )
	{ 	// We're not generating static pages nor is a caching plugin collecting the content, so we can display this block
	?>
	<?php } ?>
</div>
</div>
<div class="pagefoot">
	<p class="center">
		<a href="<?php echo $Blog->get('msgformurl').'&amp;recipient_id=1&amp;redirect_to='.rawurlencode(url_rel_to_same_host(regenerate_url('','','','&'), $Blog->get('msgformurl'))); ?>" title="Contact the Admin">Contact the admin</a>&nbsp; / &nbsp;
		<a href="http://blog.thedarksighed.com/projectblog" title="Custom b2evo skin designs at The Dark Sighed">Original B2Evo skin design by Andrew Hreschak</a><br />
		<?php
			// Display additional credits (see /conf/_advanced.php):
			display_list( $credit_links, T_('Credits').': ', ' ', '|', ' ', ' ' );
		?>
	</p>
</div>
</div>
<div class="footer">
	<?php
		$Hit->log();	// log the hit on this page
		debug_info(); // output debug info if requested
	?>
</div>
</body>
</html>