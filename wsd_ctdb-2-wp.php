<?php 
/*
Plugin Name:  Its in Progress
Plugin URI:   http://websysdynamics.com
Description:  Simple Script to import users from a db into wordpress.
Version:      000000001
Author:       websysdynamics.com
Author URI:   https://websysdynamics.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Author Info:  Skype : jawadakr 
Domain Path:  /languages
*/

//defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

ini_set('max_execution_time', 1000);

require('wp-load.php');

require("wp-config.php");

require("wp-importer/connection.php");

// for getting db tables prefix.
//$table_prefix

//require("wp-importer/functions.php");

//print_r($con);

//echo $connection_msg;

	
	$query="select * from sheet1";
	
	
	
	$result= mysqli_query($con,$query);
	
$website='';
$first_name='';
$role='';

	/*
	-Name
	-Last Name
	-Address
	-City
	-State
	-Zip
	-Phone
	-e-mail
	-Church
	-Region
	-Discipler
	-Date Reg
	-ID
	-User ID
	-User Group
	-Username
	-Password
	-Is Approved
	-Donor
	-Correspondence
	-Disciplers First Name	
	-Disciplers Last Name
	*/

$count=0;	
	
while($row = mysqli_fetch_array($result))
		{
				
	// inserting wp code to work with list of users.
	
	$email_address = $row['e-mail'];
  	$username= $row['Username'];
	echo '<hr />';
  	echo 'Adding username : '.$username.'<br />';
	
	if( null == username_exists( $username ) ) {
	
  // Generate the password and create the user
 // $password = md5($row['Password']); //wp_generate_password( 12, false );

  //$user_id = wp_create_user( $email_address, $password, $email_address );

  // Set the nickname
  /*  
	wp_update_user(
    array(
      'ID'          =>    $user_id,
      'nickname'    =>    $email_address
    )
  );
  */

$website='';

$first_name='';

$role='';

$first_name = $row['Name'];
$last_name = $row['Last Name'];

$address1 = $row['Address'];

$address2 = '';	
	
$businessname ='';
	
$city =	 $row['City'];

$state = $row['State'];

$country = '';

$zip = $row['Zip'];

$phone = $row['Phone'];	

$church = $row['Church'];
$region = $row['Region'];
$discipler = $row['Discipler'];
$Date_Reg = $row['Date Reg'];
$ID = $row['ID'];
$User_ID_CTO = $row['User ID'];

$User_Group = $row['User Group'];

$Is_Approved = $row['Is Approved'];
$Donor = $row['Donor'];
$Correspondence = $row['Correspondence'];
$Disciplers_First_Name = $row['Disciplers First Name'];
$Disciplers_Last_Name = $row['Disciplers Last Name'];
	
echo '<pre>';

print_r($row);

echo '</pre>';	
echo '<hr />';
			switch($row['User Group'])
			{
				
				case 'NULL':
				case 'visitor':
				case 'Newsletter':
				case 'vistor':
				case 'inactive':
				case 0:
				case '0': 
							
				$role='subscriber';
				
				break;
				
				case 'admin':
				case 'secondary admin':
				case 'Administration':
				
				$role='administrator';
				
				break;
				
				default:
				$role='subscriber';
				break;				
			}


//coming date from db.
//10/10/2018 2:27
//echo 'coming date : '.$coming_date = substr($row['Date Reg'],0,10);

//echo 'Coming date : '.$coming_date = explode(' ', $row['Date Reg'], 2);
$coming_date = explode(' ', $row['Date Reg'], 2);

//print_r($coming_date);

$new_date = str_replace('/','-',$coming_date[0]);
//$new_date = explode($coming_date[0],'/');
$new_date = explode('-',$new_date);
//print_r($new_date);
//$new_date_formatted= $new_date[2].'-'.$new_date[0].'-'.$new_date[1].' 00:00:00';
$new_date_formatted= $new_date[2].'-'.$new_date[0].'-'.$new_date[1].' '.$coming_date[1].':00';

//echo 'New date : '.$new_date_formatted;
//echo '<br />';	
$userdata = array(
    'user_login'  =>  $username,
    'user_url'    =>  $website,
	'user_pass'	  =>  $row['Password'],	
    'user_nicename'   =>  $username, // When creating an user, `user_pass` is expected.
	'user_email'    =>  $email_address,
	'display_name'    =>  $email_address,
	'nickname'    =>  $email_address,
	'first_name'    => $first_name,
	'last_name'    =>  $last_name,
	'description'    =>  '',
	'user_registered'    => $new_date_formatted, // $row['Date Reg'],	// Expected Date Format : Y-m-d H:i:s
	'role' =>$role
		
);

echo '<pre>';
print_r($userdata);
echo '</pre>';



$user_id = wp_insert_user( $userdata ) ;

//On success
if ( ! is_wp_error( $user_id ) ) {

    echo "User created : ". $user_id;
	
	// user is created successfully so we are going to add the remaining info here.
	
				// more improvements added to the code later.
			//	$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_first_name","'.$first_name.'") on DUPLICATE KEY UPDATE meta_key="billing_first_name", meta_value="'.$first_name.'"';

			//$result0= mysqli_query($con,$query3);
		
echo '<br /> Inserting meta data : <br />';
			
			if($first_name!='')
			{
			update_usermeta( $user_id, 'billing_first_name', $first_name );
			}
			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_last_name","'.$last_name.'") on DUPLICATE KEY UPDATE meta_key="billing_last_name", meta_value="'.$last_name.'"';

			//$result0= mysqli_query($con,$query3);
			
			if($last_name!='')
			{
			update_usermeta( $user_id, 'billing_last_name', $last_name );
			}
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_company","'.$businessname.'") on DUPLICATE KEY UPDATE meta_key="billing_company", meta_value="'.$businessname.'"';

			//$result0= mysqli_query($con,$query3);
			
			if($businessname!='')
			{
			update_usermeta( $user_id, 'billing_company', $businessname );
			}
			


			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_address_1","'.$row['address1'].'") on DUPLICATE KEY UPDATE meta_key="billing_address_1", meta_value="'.$row['address1'].'"';

			//$result0= mysqli_query($con,$query3);
			
			
			if($address1!='')
			{
			update_usermeta( $user_id, 'billing_address_1', $address1 );			
			}
			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_address_2","'.$row['address2'].'") on DUPLICATE KEY UPDATE meta_key="billing_address_2", meta_value="'.$row['address2'].'"';

			//$result0= mysqli_query($con,$query3);
			
			if($address2!='')
			{
			update_usermeta( $user_id, 'billing_address_2', $address2 );
			}
			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_city","'.$row['city'].'") on DUPLICATE KEY UPDATE meta_key="billing_city", meta_value="'.$row['city'].'"';

			//$result0= mysqli_query($con,$query3);
			if($city!='')
			{
			update_usermeta( $user_id, 'billing_city', $city );
			}
			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_state","'.$row['state'].'") on DUPLICATE KEY UPDATE meta_key="billing_state", meta_value="'.$row['state'].'"';

			//$result0= mysqli_query($con,$query3);
			if($state!='')
			{
			update_usermeta( $user_id, 'billing_state', $state );
			}



			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_country","'.$row['country'].'") on DUPLICATE KEY UPDATE meta_key="billing_last_name", meta_value="'.$row['country'].'"';

			//$result0= mysqli_query($con,$query3);
			if($country!='')
			update_usermeta( $user_id, 'billing_country', $country );
			
			//$query3='INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUES ('.$row["user_id"].',"billing_postcode","'.$row['zip'].'") on DUPLICATE KEY UPDATE meta_key="billing_postcode", meta_value="'.$row['zip'].'"';

			//$result0= mysqli_query($con,$query3);
			if($zip!='')
			{
			update_usermeta( $user_id, 'billing_postcode', $zip );
			}
			
			if($phone!='')
			{
			update_usermeta( $user_id, 'billing_phone', $phone );
			}
			
			// new variables added for john project.
			

			
			if($church!='')
			{
			update_usermeta( $user_id, 'cto_church', $church );
			}
			
			if($region!='')
			{
			update_usermeta( $user_id, 'cto_region', $region );
			}
			
			if($discipler!='')
			{
			update_usermeta( $user_id, 'cto_discipler', $discipler);
			}
			
			if($Date_Reg!='')
			{
			update_usermeta( $user_id, 'cto_date_reg', $Date_Reg);
			}
			
			if($ID!='')
			{
			update_usermeta( $user_id, 'cto_id', $ID );
			}
			
			if($User_ID_CTO!='')
			{
			update_usermeta( $user_id, 'cto_user_id', $User_ID_CTO );
			}
			
			//

			if($User_Group!='')
			{
			update_usermeta( $user_id, 'cto_user_group', $User_Group);
			}
			
			if($Is_Approved!='')
			{
			update_usermeta( $user_id, 'cto_is_approved', $Is_Approved );
			}
			
			if($Donor!='')
			{
			update_usermeta( $user_id, 'cto_donor', $Donor );
			}
			
			if($Correspondence!='')
			{
			update_usermeta( $user_id, 'cto_correspondence', $Correspondence);
			}
			
			if($Disciplers_First_Name!='')
			{
			update_usermeta( $user_id, 'cto_disciplers_first_name', $Disciplers_First_Name );
			}
		
			if($Disciplers_Last_Name!='')
			{
			update_usermeta( $user_id, 'cto_disciplers_Last_Name', $Disciplers_Last_Name );
			}
		
			
			//$user_id = wp_update_user( array( 'ID' => $row["user_id"], 'user_nicename' => $row['user_nicename'],'display_name' => $row['display_name'] ) );


// user meta ends here.
echo '<br />';
echo 'Meta Data Updated';	
echo '<br />';
echo $query3='INSERT INTO wsd_migration_log(user_id, user_name,email, notes) VALUES ('.$user_id.',"'.$username.'","'.$email_address.'","'.$username.' added with WP ID : '.$user_id.' inserted for CTO Id : '.$User_ID_CTO.'")';

	
$result0= mysqli_query($con,$query3);

	
	echo '<hr />';
}

$count++;



  // Email the user
  //wp_mail( $email_address, 'Welcome!', 'Your Password: ' . $password );


} // end

// in case of large numbr of users use the below condition to break the loop so that data added in the system stays consistent.
// or increase the execution time
//if($count==200)
//{
//	break;
//}


}
	// new code ends here 






?>