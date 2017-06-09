<?php
/**
 * category_view.php is the RSS feed list page for the RSS feed application
 *
 * The difference between demo_list.php and survey_list.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, survey_view.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package 
 * @author Amy Bartolotta 
 * @author Kevin Daniel
 * @author Morgan Richmond
 * @author Sam Richardson
 * @version 1.0 2017/06/04
 * @link 
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @see feed_view.php 
 * @todo 
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "feeds/index.php");
}


# SQL statement
$sql = "SELECT * FROM `sp17_Feeds` WHERE `FeedCategoryID` = $myID;";

#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>

<h3 align="center">News Feeds</h3>

<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

#if there are records, process them
if(mysqli_num_rows($result) > 0){
	if($myPager->showTotal()==1){$itemz = "feed";}else{$itemz = "feeds";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
	
	#start the table
	echo '
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Feed Name</th>
					<th>Feed Description</th>
				</tr>
			</thead>
			<tbody>
	';

	# process each row
	while($row = mysqli_fetch_assoc($result)){
		
		echo '
			<tr>
				<td><a href="' . VIRTUAL_PATH . 'feeds/feed_view.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['FeedTitle']) . '</a></td>
				<td>' . dbOut($row['FeedDescription']) . '</td>
			</tr>
		';
	}
	
	# complete the table
	echo '</tbody></table>';
	
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>What! No feeds?  There must be a mistake!!</div>";	
} #end if(mysqli_num_rows($result) > 0)

#release the data
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>