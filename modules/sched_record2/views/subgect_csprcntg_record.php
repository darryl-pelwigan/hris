<?=$cs['table']['table']?>
<!-- modal for create new-->
<div class="modal fade" id="classStandingModalAdd" tabindex="-1" role="dialog" aria-labelledby="classStandingModalAddLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-lightg">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="enrollListModalLabel">CREATE NEW Class Standing <?= $cs['type_d'][0] ?></h4>
                        </div>
                        <form action="#" class="form-horizontal" id="updateCS" target="_blank">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Description</label>
                                    <div class="col-md-8">
                                     <input type="text" class="form-control" id="cs_c_desc" placeholder="Description" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Items</label>
                                    <div class="col-md-8">
                                        <!-- <input type="number" class="form-control lea" id="cs_c_items" placeholder="ITEMS" /> -->
                                       <select class="form-control lea" id="cs_c_items">
                                       <option value="default">ITEMS</option>
                                            <?php 
                                                for($x=1;$x<=(20);$x++){
                                                        $gt=$x*10;
                                                    echo "<option value='". $gt."'>". $gt ."</option> ";
                                                }
                                             ?>
                                          </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                 <?php $total_cs_prcnt=($cs['table']['total_cs_prcnt']!=0)?($cs['table']['total_cs_prcnt']*.1)/0.5:0; ?>
                                    <label class="control-label col-md-3">Percent</label>
                                    <div class="col-md-8" >
                                       <select class="form-control lea" id="cs_c_prcnt">
                                       <option value="default">PERCENT</option>
                                            <?php 
                                                for($x=1;$x<=(20-($total_cs_prcnt));$x++){
                                                        $gt=$x*5;
                                                    echo "<option value='". $gt."'>". $gt ."</option> ";
                                                }
                                             ?>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">For</label>
                                    <div class="col-md-8" >
                                        <select class="form-control" id="cs_c_type">
                                        <?php 
                                            echo '<option value="'.$cs['type_d'][6] .'">'.$cs['type_d'][7].' '.$cs['type_d'][0].'</option>';
                                        ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" data-modal-id="classStandingModalAdd">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" id="classStandingModalAddButton" onclick="" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



<div class="modal fade" id="classStandingModalEdit" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content">
	                    <div class="modal-header modal-header-lightg">
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                        <h4 class="modal-title" id="enrollListModalLabel">Edit Class Standing</h4>
	                    </div>
	                    <form action="#" class="form-horizontal" id="updateCS" target="_blank">
		                    <div class="modal-body">
		                    	<div class="form-group">
		                    		<label class="control-label col-md-3">Description</label>
		                    		<div class="col-md-8">
		                    		 <input type="text" class="form-control" id="cs_e_desc" placeholder="" value="">
		                    		</div>
		                    	</div>
		                    	<div class="form-group">
		                    		<label class="control-label col-md-3">Items</label>
		                    		<div class="col-md-8">
				                    	 <select class="form-control lea" id="cs_e_items">
                                       <option value="default">ITEMS</option>
                                              <?php 
                                                for($x=1;$x<=(20);$x++){
                                                        $gt=$x*10;
                                                    echo "<option value='". $gt."'>". $gt ."</option> ";
                                                }
                                             ?>
                                          </select>
		                    		</div>
		                    	</div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Percent</label>
                                    <div class="col-md-8" >
                                       <select class="form-control lea" id="cs_e_prcnt">
                                       <option value="default">PERCENT</option>
                                            <?php 
                                                for($x=1;$x<=(20);$x++){
                                                        $gt=$x*5;
                                                    echo "<option value='". $gt."'>". $gt ."</option> ";
                                                }
                                             ?>
                                          </select>
                                    </div>
                                </div>

		                    </div>
		                    <div class="modal-footer">
		                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                        <button type="button" id="edit_cs" onclick="" class="btn btn-success">Update</button>
		                    </div>
	                    </form>
	                </div>
	            </div>
	        </div>
            
<?php
$this->load->view($get_plugins_js);