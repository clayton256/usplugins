<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
require '../../../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
//require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();}  $db=DB::getInstance(); if(!pluginActive("store")){die();}?>
<?php
if(!empty($_GET['query'])){

$query = Input::get('query');
if(is_numeric($query)){
	$check = $db->query("SELECT id FROM store_orders WHERE id = ?",array($query))->count();

	if($check > 0){
		Redirect::to('view_order.php?order='.$query);
	}else{
		$findQ = $db->query("SELECT * FROM store_orders WHERE archived = 0 AND (email LIKE '%$query%' OR id LIKE '%$query%' OR fullname LIKE '%$query%'OR notes LIKE '%$query%')");
		$findC = $findQ->count();
		if($findC > 0){

			Redirect::to('search_orders.php?q='.$query);
		}
	}
}
}
?>
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-header text-center">
					Search Orders
				</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 offset-md-3 text-center">
				<strong>Enter an Order Number, Name, or Email Address</strong>
				<form class="" action="search_orders.php" method="get">
					<div class="input-group mb-3">
					  <input type="text" name="query" value="" class="form-control" >
					  <div class="input-group-append">
					    <input type="submit" name="submit" value="search" class="btn btn-primary">
					  </div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<?php
				$query = Input::get('query');
				if(!empty($query)){
					$find = $db->query("SELECT * FROM store_orders WHERE archived = 0 AND (email LIKE '%$query%' OR id LIKE '%$query%' OR fullname LIKE '%$query%'OR notes LIKE '%$query%')")->results();
					?>
					<table class="table table-striped">
						<h4 align="center">Click an Order to View It</h4>
						<thead>
							<tr>
								<th>Order Number</th>
								<th>Customer</th>
								<th>Email</th>
								<th>Phone</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($find as $f){ ?>

								 <tr>
								 	<td><a href="view_order.php?order=<?=$f->id?>"><?=$f->id?></a></td>
									<td><a href="view_order.php?order=<?=$f->id?>"><?=$f->fullname?></a></td>
									<td><a href="view_order.php?order=<?=$f->id?>"><?=$f->email?></a></td>
									<td><a href="view_order.php?order=<?=$f->id?>"><?=$f->phone?></a></td>
								 </tr>

							<?php } ?>
						</tbody>
					</table>
				<?php } ?>
			</div>
		</div>
			</div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->


<?php //require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
