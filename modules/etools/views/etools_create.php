<div id="page-wrapper">

      <!-- Subject info -->
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default panel-overflow">
                    <div class="panel-heading">
                            <h1 >
                                CREATE EVALUATION TOOL
                            </h1>
                    </div>
                    <div class="panel-body">
                        <form id="creating_etools" >
                        <input type="hidden" name="etools_cats_num" id="etools_cats_num" value="0" />

                            <div class="form-group ">
                              <label for="etools_title" class="col-sm-2 col-form-label">ETOOL TITLE</label>
                              <div class="col-sm-7">
                                <input type="text" class="form-control" name="etools_title" id="etools_title" placeholder="ETOOL TITLE">
                              </div>
                              <div class="col-sm-2">
                                <input type="text" class="form-control" name="etools_code" id="etools_code" placeholder="ETOOL CODE">
                              </div>
                                <div class="col-sm-1  ">
                                    <span id="etools_cats_prcntx">0%</span>
                                    <input type="hidden" name="etools_cats_prcnt"   class="form-control" id="etools_cats_prcnt" value="0" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cats_pa_more" class="col-sm-2 col-form-label">ADD CATEGORY</label>
                              <div class="col-sm-10">
                                <button type="button" class="col-md-1 col-md-offset-1 btn btn-success btn-xs" id="cats_pa_more"><i class="fa fa-plus"></i></button>
                                <span class="col-md-10 bg-danger hide" id="etools_error" ></span>
                              </div>
                            </div>
                            <hr />
                            <div id="etools_category"></div>

                            <div class="form-group ">
                               <label for="etools_comments" class="col-sm-2 col-form-label">COMMENTS</label>
                               <div class="offset-sm-9 col-sm-1">
                                 <input type="checkbox" class="form-control" name="etools_comments" id="etools_comments" checked="checked" value="1" />
                              </div>
							</div>
                             <hr />

                            <div class="form-group ">
                              <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" disabled="disabled" id="submit_etools">CREATE</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
