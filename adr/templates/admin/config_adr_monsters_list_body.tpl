<h1>{L_MONSTERS_TITLE}</h1>

<P>{L_MONSTERS_TEXT}</p>

<form method="post" action="{S_MONSTERS_ACTION}">

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="center" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;:&nbsp;<input type="submit" value="{L_SORT}" class="liteoption" /></span></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_NAME}</th>
		<th class="thTop">{L_IMG}</th>
		<th class="thTop">{L_LEVEL}</th>
		<th class="thTop">{L_BASE_HP}</th>
		<th class="thTop">{L_BASE_MP}</th>
		<th class="thTop">{L_BASE_MP_POWER}</th>
		<th class="thTop">{L_BASE_MA}</th>
		<th class="thTop">{L_BASE_MD}</th>
		<th class="thTop">{L_BASE_ELEMENT}</th>
		<th class="thTop">{L_BASE_DEF}</th>
		<th class="thTop">{L_BASE_ATT}</th>
		<th class="thTop">{L_BASE_SP}</th>

		<th class="thTop">{L_ZONE_TITLE}</th>
		<th class="thTop">{L_SEASON_TITLE}</th>
		<th class="thTop">{L_WEATHER_TITLE}</th>
		<th class="thTop">{L_ITEM_TITLE}</th>
		<th class="thTop">{L_MESSAGE_TITLE}</th>

		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN monsters -->
	<tr>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.NAME}</td>
		<td class="{monsters.ROW_CLASS}" align="center"><img src="../adr/images/monsters/{monsters.IMG}" alt="{monsters.NAME}" /></td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.LEVEL}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_HP}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_MP}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_MP_POWER}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_MA}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_MD}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_ELEMENT}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_DEF}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_ATT}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.BASE_SP}</td>

		<td class="{monsters.ROW_CLASS}" align="center">{monsters.ZONE}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.SEASON}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.WEATHER}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.ITEM}</td>
		<td class="{monsters.ROW_CLASS}" align="center">{monsters.MESSAGE}</td>

		<td class="{monsters.ROW_CLASS}" align="center"><a href="{monsters.U_MONSTERS_EDIT}">{L_EDIT}</a></td>
		<td class="{monsters.ROW_CLASS}" align="center"><a href="{monsters.U_MONSTERS_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END monsters -->
	<tr>

		<td class="catBottom" colspan="19"


	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="gensmall"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
</form>

<br clear="all" />