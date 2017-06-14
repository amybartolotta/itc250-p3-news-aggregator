<?php
/**
 * feed_view.php is the RSS feed view page for the RSS feed application
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
 * @see category_view.php 
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
$sql = "SELECT * FROM `sp17_Feeds` WHERE `FeedID` = $myID;";


#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>

<!--
<h3 align="center">News Feed</h3>

<p>This is the page where we are going to do the caching and display the RSS feed.  This is just a placeholde to be sure we are getting the right record from the database.</p>
-->

<?php
//if there isn't a session started already start one
//prevents warning notices if session is already started
if(!isset($_SESSION)){session_start();}

#The session variable Feeds will be an array of Feed objects.  The index in the array should be the FeedID. The FeedID is $myID

# check to see if there is session variable. if not make one
if(!isset($_SESSION['Feeds'])){
	$_SESSION['Feeds'] = array();
}


# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


if(mysqli_num_rows($result) > 0)
{#records exist - process
	
	# there should only be one row so I don't think we need a loop
	$row = mysqli_fetch_assoc($result);
	
	#setup the RSS stuff
	$cacheTTL = 10 * 60; #this the cache time to live in seconds. If the cache is older than this we need to refresh
	$RSSoutput = ""; #store the RSS feed output here
	$request = dbOut($row['FeedLink']); # $request now has the URL for the feed
		
	# check to see if there is a Feed object with $myID in the session and if not make one
	if (!array_key_exists($myID,$_SESSION['Feeds'])){
		
		$response = file_get_contents($request); #this is where we are hitting the external server
		$_SESSION['Feeds'][$myID] = new Feed($myID,$response,time()); #store the response in the session variable

	}else{
		
		#check to see if we are forcing the clearing of the cache by returning a value for clearCache in the query string
		if (isset($_GET['clearCache'])) {
			$cacheTTL = 0;
		}
		
		#check to see if the cache should be refreshed
		if ((time() - $_SESSION['Feeds'][$myID]->Timestamp) > $cacheTTL){
			
			# the cache is stale so reload the feed
			$response = file_get_contents($request); #this is where we are hitting the external server
			$_SESSION['Feeds'][$myID]->Response = $response; #cache the new response
			$_SESSION['Feeds'][$myID]->Timestamp = time(); #update the timestamp
			
		}else{

			#the cache is still fresh so use the response from the cache
			$response = $_SESSION['Feeds'][$myID]->Response;

		} #end if ((time() - $_SESSION['Feeds'][$myID]->Timestamp) > $cacheTTL)
	} #end if(!array_key_exists($myID,$_SESSION['Feeds']))
		

	
	
	#render the RSS feed
	$xml = simplexml_load_string($response);
	
	#output the time the feed was cached
	$RSSoutput .=  '<p>Cached on ' . date("l jS \of F Y h:i:s A", $_SESSION['Feeds'][$myID]->Timestamp) . " ";

	#output link to force a cache refresh
	$RSSoutput .=  '<a href="' . THIS_PAGE . '?id=' . $myID . '&clearCache=1">Refresh feed</a></p>';
	
	$RSSoutput .= '<h3 align="center">' . $xml->channel->title . '</h3>';

	foreach($xml->channel->item as $story)
	{
	    $RSSoutput .= '<table class="table table-striped table-hover ">';
		$RSSoutput .= '<thead><tr><td><a href="' . $story->link . '">' . $story->title . '</a></td></tr></thead>'; 
		$RSSoutput .= '<tr><td>' . $story->description . '</td></tr>';
		$RSSoutput .= '</table>';
	}
	
	#display the RSS
	echo $RSSoutput;

}else{#no records
    echo "<div align=center>What! No feeds?  There must be a mistake!</div>";	
}#end if(mysqli_num_rows($result) > 0)

#release the data
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php





# ------- class Feed -----------------------------------------

class Feed
{
	//public member variables (properties)
 	public $ID = '';
 	public $Response = '';
 	public $Timestamp = 0;
	
    function __construct($id,$response,$timestamp)
	{//constructor sets stage by adding data to an instance of the object
		
		$this->ID = (int)$id;
		$this->Response = $response;
		$this->Timestamp = (int)$timestamp;
	}
}



?>