<!-- general question Modal -->
<div id="generalQuesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Question!</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height:400px; overflow-y:scroll;">
				<label class="col-form-label">Type</label>

				<div class="form-group">
					<input class="form-check-input genQuesType" type="radio" name="genQuesType" id="genQuesTypechek1" value="1" checked="">
					<label class="form-check-label" for="genQuesTypechek1">Single</label>

					<input class="form-check-input genQuesType" type="radio" name="genQuesType" value="2" id="genQuesTypechek2" >
					<label class="form-check-label" for="genQuesTypechek2">Multiple</label>
				</div>
				<div class="form-group">
					<input type="hidden" id="hiddenGenBlcNum">
					<textarea class="form-control rounded-0" id="genQuesName" name="genQuesName" placeholder="Question Name" rows="2"></textarea>
					<label class="genQuesName_err"></label>
				</div>
				<div class="form-group texarea">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt1" placeholder="Option1">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt2" placeholder="Option2">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt3" placeholder="Option3">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt4" placeholder="Option4">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt5" placeholder="Option5">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt6" placeholder="Option6">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt7" placeholder="Option7">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt8" placeholder="Option8">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt9" placeholder="Option9">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt10" placeholder="Option10">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt11" placeholder="Option11">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt12" placeholder="Option12">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt13" placeholder="Option13">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt14" placeholder="Option14">
					<input type="text" class="form-control genQuesOpt" id="genQuesOpt15" placeholder="Option15">
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary addGenQuestion">Add</button>
			</div>
		</div>
	</div>
</div>
