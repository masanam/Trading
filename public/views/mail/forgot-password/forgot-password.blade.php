<div>
	@if(config('app.deployment') == 'berau')
	<h2>BC Price Approval</h2>
	@elseif(config('app.deployment') == 'bib')
	<h2>CT Approval</h2>
	@endif

	<p>
		You've sent a forgot password request from
		@if(config('app.deployment') == 'berau')
		BC Price Approval
		@elseif(config('app.deployment') == 'bib')
		CT Approval
		@endif
		 to this email.
		This is your new password:
	</p>
	<br/><br/>
	<center>
		<p>
			email : {{ $email }}
		</p>
		<br/>
		<p>
			password : {{ $password }}
		</p>
	</center>
	<br/><br/>
	<p>
		Feel free to ignore this message if you didn't request this.
	</p>
</div>
