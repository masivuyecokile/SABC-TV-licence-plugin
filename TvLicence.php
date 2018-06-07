<?php
/**
 * Plugin Name: SABC TV Licence
 * Description: Log all TV Licence entries and store in a database.
 * Author:      Personalised Promotion
 * Version:     1.0.0
 * Author URI:  https://www.personal.co.za
 * Plugin URI:  https://www.personal.co.za
 */
defined('ABSPATH') or die("THIS IS JUST A PLUGIN, YOU CAN'T ACCESS DATA DIRECTLTY");

	$icon = "logo.ico";
	add_action('admin_menu', 'pluginup');
 
 
function pluginup(){
  
        add_menu_page('tvlicence','SABC TV Licence','manage_options','tvlicence','start','logo.ico',null);
}
		include ("connection.php");

		function activate(){

			$sql = "CREATE TABLE IF NOT EXISTS `wp_tvlicence_entries` (
				  `entryID` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT NOT NULL,
				  `type` varchar(20) DEFAULT NULL,
				  `accountnumber` varchar(100) DEFAULT NULL,
				  `message` varchar(100) DEFAULT NULL,
				  `balance` varchar(30) DEFAULT NULL,
				  `initials` varchar(30) DEFAULT NULL,
				  `lastname` varchar(255) DEFAULT NULL,
				  `suburb` varchar(255) DEFAULT NULL,
				  `idnum` varchar(15) DEFAULT NULL,
				  `datecreated` timestamp default current_timestamp
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

				$stmt = conn::run($sql);

				flush_rewrite_rules();

				//load css
				
			}
	register_activation_hook(__FILE__,"activate");

			function deregister(){

				flush_rewrite_rules();

			}
			register_activation_hook(__FILE__,"activate");
			register_deactivation_hook(__FILE__,'deregister');
			



	function start(){
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ) . 'css/tvlicence.css';?>">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.css"/>
		 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.js"></script>

		<div id="pluginbody">
			<h1>Tv Licence Entries</h1>
			<?php

				$sql = "SELECT entryID,type,accountnumber,message,datecreated,balance,initials,lastname,suburb,idnum FROM wp_tvlicence_entries ORDER BY entryID DESC";
				$stmt = conn::run($sql);
				$results = $stmt->fetchall();
				if (count($results) > 0) {?>

					<table id="entriestable" class="table table-stripped table-responsive table-border">
						<thead>
						<tr>
			                <th>Entry ID</th>
			                <th>Entry Date</th>
			                <th>Account Number</th>
			                <th>Message</th>
			                <th>Balance</th>
			                <th>Initials</th>
			                <th>LastName</th>
			                <th>ID Number /  Business Reg number</th>
			              </tr>
			          </thead>
			          <tbody>
			           <?php

			           		foreach($results as $key=>$row):?>
			           		<tr>
			           			<td><?=$row['entryID']?></td>
			           			<td><?=$row['datecreated']?></td>
			           			<td><?=$row['accountnumber']?></td>
			           			<td><?=$row['message']?></td>
			           			<td><?=$row['balance']?></td>
			           			<td><?=$row['initials']?></td>
			           			<td><?=$row['lastname']?></td>
			           			<td><?=$row['idnum']?></td>
			           		</tr>
			           		<?php
			           			endforeach;
			           	?>
			           </tbody>
					</table>

					<script type="text/javascript">
						$('document').ready(function(){

							$('#entriestable').DataTable({

								"order": [ 0, 'DESC' ],
								 select: true,
							});
						})
					</script>
				<?php

				} else {
					
					echo "<p> No entries found</th>";
				}
				
		?>
		</div>


		<?php

	}