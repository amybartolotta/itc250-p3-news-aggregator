<?php
/**
 * survey_view.php is a page to demonstrate the proof of concept of the 
 * initial SurveySez objects.
 *
 * Objects in this version are the Survey, Question & Answer objects
 * 
 * @package 
 * @author 
 * @version 
 * @link 
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see 
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
$sql = "SELECT * FROM `sp17_Feeds` WHERE `FeedID` = $myID;";

/*
$mySurvey = new SurveySez\Survey($myID); //MY_Survey extends survey class so methods can be added
if($mySurvey->isValid)
{
	$config->titleTag = "'" . $mySurvey->Title . "' Survey!";
}else{
	$config->titleTag = smartTitle(); //use constant 
}
*/

#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>

<!--
<h3 align="center">News Feed</h3>

<p>This is the page where we are going to do the caching and display the RSS feed.  This is just a placeholde to be sure we are getting the right record from the database.</p>
-->

<?php

# there should only be one row so we don't need the pager
#reference images for pager
#$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
#$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
#$myPager = new Pager(10,'',$prev,$next,'');
#$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


if(mysqli_num_rows($result) > 0)
{#records exist - process
	
	# there should only be one row so I don't think we need a loop
	$row = mysqli_fetch_assoc($result);
	
	#do the RSS stuff
	$request = dbOut($row['FeedLink']);
	$response = file_get_contents($request);
	$xml = simplexml_load_string($response);
	
	echo '<h3 align="center">' . $xml->channel->title . '</h3>';
  
	foreach($xml->channel->item as $story)
	{
	    echo '<table class="table table-striped table-hover ">';
		echo '<thead><tr><td><a href="' . $story->link . '">' . $story->title . '</a></td></tr></thead>'; 
		echo '<tr><td>' . $story->description . '</td></tr>';
		echo '</table>';
	}

}else{#no records
    echo "<div align=center>What! No feeds?  There must be a mistake!!</div>";	
}#end if(mysqli_num_rows($result) > 0)


@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>