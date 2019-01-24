<div>
	<p>
		Specify the Name, User Role and Path for Dashboard.
	</p>
</div>

<div id="qw-create">
	<form action='admin.php?page=query-wrangler&action=create&noheader=true'
	      method='post'>
		<div class="qw-setting">
			<label class="qw-label">Dashboard Name:</label>
			<input class="qw-create-input" type="text" name="dashboard-name" value=""/>

			<p class="description">Dashboard Name depicts the user it is being created for</p>
		</div>

		<div class="qw-setting">
			<label class="qw-label">User Role:</label>
			<select name="qw-type" class="qw-create-select">
				<?php
				  	$options = '';
				    foreach ($arguments['user_roles'] as $key => $value) {
				       $options.='<option value='.$key.'>'.$value.'</option>';
				    }
				    echo $options;
					
				 ?>			
			</select>

			<p class="description">User role will allow only selected user to see this dashboard.</p>
		</div>

		<div class="qw-create">
			<input type="submit" value="create" class="button-primary"/>
		</div>
	</form>
</div>

