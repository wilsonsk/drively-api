											<form id="contact-form">
												<div class="row">
													<div class="control-group col-sm-6">
														<label class="control-label required" for="fname">First Name <i class="fa fa-asterisk"></i>
															<em><span id="fname-counter" class="counter-disp">0</span> of 25 Characters</em>
														</label>
														<input type="text" name="fname" id="fname-id" class="form-control counter" maxlength="25">
													</div>
													<div class="control-group col-sm-6">
														<label class="control-label required" for="lname">Last Name <i class="fa fa-asterisk"></i>
															<em><span id="lname-counter" class="counter-disp">0</span> of 45 Characters</em>
														</label>
														<input type="text" name="lname" id="lname-id" class="form-control counter" maxlength="45">
													</div>
												</div>
												<div class="row">
													<div class="control-group col-sm-4">
														<label for="phone" data-fmt="phone">Phone </label>
														<input type="text" name="phone" id="phone-id" class="form-control numbers">
													</div>
													<div class="control-group col-sm-2">
														<label for="phone_ext" data-fmt="phone">Ext. </label>
														<input type="text" name="phone_ext" id="phone_ext-id" class="form-control numbers">
													</div>
													<div class="control-group col-sm-6">
														<label for="mobile" data-fmt="phone">Mobile <em><span id="mobile-counter" class="counter-disp">0</span> of 12 Characters</em></label>
														<input type="text" name="mobile" id="mobile-id" class="form-control counter numbers" maxlength="12">
													</div>
												</div>
												<div class="row">
													<div class="control-group col-sm-6">
														<label for="email">Email <em><span id="email-counter" class="counter-disp">0</span> of 125 Characters</em></label>
														<input type="text" name="email" id="email-id" class="form-control counter" maxlength="125">
													</div>
													<div class="control-group col-sm-6">
														<label for="title">Title <em><span id="title-counter" class="counter-disp">0</span> of 100 Characters</em></label>
														<input type="text" name="title" id="title-id" class="form-control counter" maxlength="100">
													</div>
												</div>
												<div class="row">
													<div class="control-group col-sm-12">
														<label for="description">Description</label>
														<textarea name="description" id="description-id" class="form-control"></textarea>
													</div>
												</div>
												<input type="hidden" name="id" id="id-id" value="0">
												<input type="hidden" name="ref_fk" id="ref_fk-id" value="0">
												<input type="hidden" name="ref_table" id="ref_table-id">
											</form>
											<div class="row">
												<div class="col-sm-4"><i class="fa fa-asterisk" style="color: #cf3232;"></i> Required Fields</div>
												<div class="col-sm-8 text-right">
													<button class="btn btn-info btn-form-cancel" id="btn_return_contacts-id"><i class="fa fa-reply"></i> Return to Contacts</button>
													<button id="btn-contact-save" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
												</div>
											</div>