@extends('layout')

@section('content')
@include('flash')
<!-- page content -->
<div class="card">
	{!!Form::open(['route'=>['backend.request_masters.store'],'files'=>true,'class'=>'form-horizontal'])!!}
	<div class="card-body">
		<h3 class="card-title">Form Request Master</h3>
			<div class="mb-3 row">
				<label for="clientName" class="col-sm-2 col-form-label">Client Name<span class="required">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="client_name" required="required" value="{{old('client_name')}}">
				</div>
			</div>
			<div class="mb-3 row">
				<label for="auditDate" class="col-sm-2 col-form-label">Audit Date<span class="required">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="audit_date" value="{{old('audit_date')}}" placeholder="dd-mm-yyyy" required="required" id="auditDate" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
					<script>
						function timeFunctionLong(input) {
							setTimeout(function() {
								input.type = 'text';
							}, 60000);
						}
					</script>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="responsibleOfficer" class="col-sm-2 col-form-label">Responsible Officer<span class="required">*</span></label>
				<div class="col-sm-10">
					<select id="responsibleOfficer" value="{{old('responsible_office')}}" name="responsible_office" class="form-control" required>
						<option value="">---Select Responsible Officer---</option>
						<option value="New Delhi">New Delhi</option>
						<option value="Aerocity, New Delhi">Aerocity, New Delhi</option>
						<option value="Ahmedabad">Ahmedabad</option>
						<option value="Bengaluru">Bengaluru</option>
						<option value="Chandigarh">Chandigarh</option>
						<option value="Dehradun">Dehradun</option>
						<option value="Gurugram">Gurugram</option>
						<option value="Hyderabad">Hyderabad</option>
						<option value="Kochi">Kochi</option>
						<option value="Kolkata">Kolkata</option>
						<option value="Mumbai">Mumbai</option>
						<option value="Andheri, Mumbai">Andheri, Mumbai</option>
						<option value="Noida">Noida</option>
						<option value="Pune">Pune</option>
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="engegmentTeam" class="col-sm-2 col-form-label">Engement Team<span class="required">*</span></label>
				<div class="col-sm-10">
					<select id="engegmentTeam" name="et_user_id[]" class="form-control" multiple="multiple" required>
						<option value="">---Select Engement Team---</option>
						@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="engegmentManager" class="col-sm-2 col-form-label">Engement Manager<span class="required">*</span></label>
				<div class="col-sm-10">
					<select id="engegmentManager" name="et_manager" value="{{old('et_manager')}}" class="form-control" required>
						<option value="">---Select Engement Manager---</option>
						@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="engegmentPartner" class="col-sm-2 col-form-label">Engement Partner<span class="required">*</span></label>
				<div class="col-sm-10">
					<select id="engegmentPartner" name="et_partner" value="{{old('et_partner')}}" class="form-control" required>
						<option value="">---Select Engement Partner---</option>
						@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="engegmentReviewer" class="col-sm-2 col-form-label">Engement Reviewer<span class="required">*</span></label>
				<div class="col-sm-10">
					<select id="engegmentReviewer" name="qc_reviewer" value="{{old('qc_reviewer')}}" class="form-control" required>
						<option value="">---Select Engement Reviewer---</option>
						@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<h2>Documents</h2>
			<table class="table table-border">
				<tbody>
					<tr>
						<th scope="row">Signed financial statement of previous year</th>
						<td></td>
						<td><input type="file" name="sfspy_standalone_file" class="form-control" placeholder="Default Input"></td>
					</tr>
					<tr>
						<th scope="row">Signed financial statement of previous year</th>
						<td>
							<select id="heard" name="sfspy_consol_option" value="{{old('sfspy_consol_option')}}" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>
						<td><input type="file" name="sfspy_consol_file" class="form-control" placeholder="Default Input"></td>
					</tr>
					<tr>
						<th scope="row">Draft financial statement of current year</th>
						<td></td>
						<td><input type="file" name="dfscy_standalone_file" class="form-control" placeholder="Default Input"></td>
					</tr>
					<tr>
						<th scope="row">Signed financial statement of previous year</th>
						<td>
							<select id="heard" name="dfscy_consolidated_option" value="{{old('dfscy_consolidated_option')}}" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>
						<td><input type="file" name="dfscy_consolidated_file" class="form-control" placeholder="Default Input"></td>
					</tr>
					<tr>
						<th scope="row">Draft discloser cheaklist</th>
						<td></td>
						<td><input type="file" name="draft_disclosure_checklist_file" class="form-control" placeholder="Default Input"></td>
					</tr>
					<tr>
						<th scope="row">Draft ind AS checklist</th>
						<td></td>
						<td><input type="file" name="draft_ind_as_checklist" class="form-control" placeholder="Default Input"></td>
					</tr>
				</tbody>
			</table>
	
	</div>
	<div class="card-body">
		<button type="submit" class="btn btn-success flot-left">Submit</button>
  	</div>
	{!!Form::close()!!}
</div>
<!-- /page content -->
@endsection
