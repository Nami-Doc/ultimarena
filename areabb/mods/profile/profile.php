<?php

global $securite;
if( $securite == 1 )
{
	$onglets[] = 'Accueil Profile';
	return true;
	exit;
}


define('IN_PHPBB', true);
$phpbb_root_path = '../../../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
$root_extreme = '../../';
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_NEWS);
init_userprefs($userdata);
//
// End session management
//


$profiledata = get_userdata($HTTP_GET_VARS['id']);

if (!$profiledata)
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

//
// Output page header and profile_view template
//

$template->set_filenames(array(
	'profile' => $root_extreme.'areabb/mods/profile/tpl/profile_view_body.tpl')
);

//
// Calculate the number of days this user has been a member ($memberdays)
// Then calculate their posts per day
//
$regdate = $profiledata['user_regdate'];
$memberdays = max(1, round( ( time() - $regdate ) / 86400 ));
$posts_per_day = $profiledata['user_posts'] / $memberdays;

// Get the users percentage of total posts
if ( $profiledata['user_posts'] != 0  )
{
	$total_posts = get_db_stat('postcount');
	$percentage = ( $total_posts ) ? min(100, ($profiledata['user_posts'] / $total_posts) * 100) : 0;
}
else
{
	$percentage = 0;
}

$avatar_img = '';
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
{
	switch( $profiledata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' .$board_config['avatar_gallery_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	}
}

$poster_rank = '';
$rank_image = '';
if ( $profiledata['user_rank'] )
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_rank'] == $ranksrow[$i]['rank_id'] && $ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}
else
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_posts'] >= $ranksrow[$i]['rank_min'] && !$ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}

$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )
{
	$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $profiledata['user_id']) : 'mailto:' . $profiledata['user_email'];

	$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
	$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
}
else
{
	$email_img = '&nbsp;';
	$email = '&nbsp;';
}

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '&nbsp;';
$www = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww">' . $profiledata['user_website'] . '</a>' : '&nbsp;';

if ( !empty($profiledata['user_icq']) )
{
	$icq_status_img = '<a href="http://wwp.icq.com/' . $profiledata['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $profiledata['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
	$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '"><img src="' .$images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
	$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '">' . $lang['ICQ'] . '</a>';
}
else
{
	$icq_status_img = '&nbsp;';
	$icq_img = '&nbsp;';
	$icq = '&nbsp;';
}

$aim_img = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '&nbsp;';
$aim = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '&nbsp;';

$msn_img = ( $profiledata['user_msnm'] ) ? $profiledata['user_msnm'] : '&nbsp;';
$msn = $msn_img;

$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($profiledata['username']) . "&amp;showresults=posts");
$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" title="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" border="0" /></a>';
$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '</a>';


if (function_exists('get_html_translation_table'))
{
	$u_search_author = urlencode(strtr($profiledata['username'], array_flip(get_html_translation_table(HTML_ENTITIES))));
}
else
{
	$u_search_author = urlencode(str_replace(array('&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array('&', "'", '"', '<', '>'), $profiledata['username']));
}

$template->assign_vars(array(
	'USERNAME' => utf8_encode($profiledata['username']),
	'JOINED' => utf8_encode(create_date($lang['DATE_FORMAT'], $profiledata['user_regdate'], $board_config['board_timezone'])),
	'POSTER_RANK' => utf8_encode($poster_rank),
	'RANK_IMAGE' => utf8_encode($rank_image),
	'POSTS_PER_DAY' => utf8_encode($posts_per_day),
	'POSTS' => utf8_encode($profiledata['user_posts']),
	'PERCENTAGE' => utf8_encode($percentage . '%'), 
	'POST_DAY_STATS' => utf8_encode(sprintf($lang['User_post_day_stats'], $posts_per_day)), 
	'POST_PERCENT_STATS' => utf8_encode(sprintf($lang['User_post_pct_stats'], $percentage)), 

	'SEARCH_IMG' => utf8_encode($search_img),
	'SEARCH' => utf8_encode($search),
	'PM_IMG' => utf8_encode($pm_img),
	'PM' => utf8_encode($pm),
	'EMAIL_IMG' => utf8_encode($email_img),
	'EMAIL' => utf8_encode($email),
	'WWW_IMG' => utf8_encode($www_img),
	'WWW' => utf8_encode($www),
	'ICQ_STATUS_IMG' => utf8_encode($icq_status_img),
	'ICQ_IMG' => utf8_encode($icq_img), 
	'ICQ' => utf8_encode($icq), 
	'AIM_IMG' => utf8_encode($aim_img),
	'AIM' => utf8_encode($aim),
	'MSN_IMG' => utf8_encode($msn_img),
	'MSN' => utf8_encode($msn),
	'YIM_IMG' => utf8_encode($yim_img),
	'YIM' => utf8_encode($yim),

	'LOCATION' => ( $profiledata['user_from'] ) ? utf8_encode($profiledata['user_from']) : '&nbsp;',
	'OCCUPATION' => ( $profiledata['user_occ'] ) ? utf8_encode($profiledata['user_occ']) : '&nbsp;',
	'INTERESTS' => ( $profiledata['user_interests'] ) ? utf8_encode($profiledata['user_interests']) : '&nbsp;',
	'AVATAR_IMG' => $avatar_img,

	'L_VIEWING_PROFILE' => utf8_encode(sprintf($lang['Viewing_user_profile'], $profiledata['username'])), 
	'L_ABOUT_USER' => utf8_encode(sprintf($lang['About_user'], $profiledata['username'])), 
	'L_AVATAR' => utf8_encode($lang['Avatar']), 
	'L_POSTER_RANK' => utf8_encode($lang['Poster_rank']), 
	'L_JOINED' => utf8_encode($lang['Joined']), 
	'L_TOTAL_POSTS' => utf8_encode($lang['Total_posts']), 
	'L_SEARCH_USER_POSTS' => utf8_encode(sprintf($lang['Search_user_posts'], $profiledata['username'])), 
	'L_CONTACT' => utf8_encode($lang['Contact']),
	'L_EMAIL_ADDRESS' => utf8_encode($lang['Email_address']),
	'L_EMAIL' => utf8_encode($lang['Email']),
	'L_PM' => utf8_encode($lang['Private_Message']),
	'L_ICQ_NUMBER' => utf8_encode($lang['ICQ']),
	'L_YAHOO' => utf8_encode($lang['YIM']),
	'L_AIM' => utf8_encode($lang['AIM']),
	'L_MESSENGER' => utf8_encode($lang['MSNM']),
	'L_WEBSITE' => utf8_encode($lang['Website']),
	'L_LOCATION' => utf8_encode($lang['Location']),
	'L_OCCUPATION' => utf8_encode($lang['Occupation']),
	'L_INTERESTS' => utf8_encode($lang['Interests']),

	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author),

	'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
);

$template->pparse('profile');


?>