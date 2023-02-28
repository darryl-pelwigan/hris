<div id="page-wrapper">
  
    <div class="col-lg-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            Approving Positions
	        </div>
	        <div class="panel-body">
	          	<table class="table-bordered table-hover" width="100%">
	          		<thead>
	          			<tr>
	          				<th>Category</th>
	          				<th>Approving Position</th>
	          				<th>Action</th>
	          			</tr>
	          		</thead>
	          		<tbody>
	          			<?php 
		          			$options = '';
			          		$category = ['dean', 'oic', 'staff', 'supervisor', 'faculty', 'vp'];
		          			foreach($category as $p){
		          				$options .= '<option>'.strtoupper($p).'</option>';
		          			}

		          			foreach ($category as $c) {
		          				$approvingranks = [];
		          				if($approving_pos){
			          				foreach($approving_pos as $pos){
			          					if($pos->category == $c){
			          						array_push($approvingranks, $pos);
			          					}
			          				}
		          				}
		          				echo '<tr>
									<td style="text-align: center;">'.strtoupper($c).'</td>
									<form action="'.base_url('hr/approval/add_approving_position').'" method="POST">
										<td>
											<input type="hidden" name="position_id" id="position_id_'.$c.'" value="'.$c.'">
											<div class="col-md-12" style="margin-bottom:15px; margin-top: 5px;">
												<select name="approving_position" class="form-control approving_position" required>
													<option value=""></option>
													'.$options.'
												</select>
											</div>
											<div class="col-md-11">
												<table class="table-bordered" width="100%" style="margin-bottom:15px;" id="approving_table_'.$c.'">
													<thead>
														<tr>
															<th>Approving Position</th>
															<th>Approving Level</th>
														</tr>
													</thead>
													<tbody>';
														if($approvingranks){
															foreach($approvingranks as $a){
																echo '<tr>
																	<td>'.$a->category_approval.'</td>
																	<td>'.$a->approval_level.'</td>
																</tr>';
															}
														}else{
															echo '<tr>
																<td colspan="2">No data.</td>
															</tr>';
														}
													echo '</tbody>
												</table>
											</div>
										</td>
										<td style="text-align: center;">
										<button class="btn btn-primary btn-sm" type="submit"> <i class="fa fa-save"></i></button><br>
										<button style="margin-top: 5px;" class="btn btn-danger btn-sm" type="button" onclick="reset_function(`'.$c.'`); ">
											<i class="fa fa-undo"></i>
											Reset
										</button>
						
										</td>
									</form>
		          				</tr>';
		          			}

	          			?>
	          		</tbody>
	          	</table>
	        </div>
	    </div>
	</div>
	
</div> <!-- /#page-wrapper -->
