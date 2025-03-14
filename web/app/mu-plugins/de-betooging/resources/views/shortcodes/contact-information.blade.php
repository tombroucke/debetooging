@if(!$property)
	{!! DeBetoogingContactInformation::formattedAddress() !!}
	{!! DeBetoogingContactInformation::formattedPhoneEmail() !!}
@else
	@if($property == 'address')
		{!! DeBetoogingContactInformation::formattedAddress() !!}
	@endif
	@if($property == 'phone' && DeBetoogingContactInformation::phone())
		{!! DeBetoogingContactInformation::formattedPhone() !!}
	@endif
	@if($property == 'email' && DeBetoogingContactInformation::email())
		{!! DeBetoogingContactInformation::formattedEmail() !!}
	@endif
	@if($property == 'vat_number' && DeBetoogingContactInformation::vatNumber())
		{!! DeBetoogingContactInformation::vatNumber() !!}
	@endif
	@if($property == 'bank_account_number' && DeBetoogingContactInformation::bankAccountNumber())
		{!! DeBetoogingContactInformation::bankAccountNumber() !!}
	@endif
@endif
