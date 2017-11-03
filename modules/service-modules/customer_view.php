<div class="customer-card">
	<table width="100%">
		<tr>
			<td width="150">
				<strong>Geregistreerd op:</strong>
			</td>
			
			<td>
				{{customer-NAME}}
			</td>
		</tr>
		
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
		<tr>
			<td>
				<strong>Adresgegevens:</strong>
			</td>
			
			<td>
				{{customer-ADDRESS}}
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			
			<td>
				{{customer-ZIPCODE}}
				{{customer-CITY}}
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			
			<td>
				{{customer-COUNTRY}}
			</td>
		</tr>
		
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
		<tr>
			<td>
				<strong>Contactgegevens:</strong>
			</td>
			
			<td>
				{{customer-EMAIL}}
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			
			<td>
				{{customer-PHONE}}
			</td>
		</tr>
	</table>
</div>

<div class="customer-card">
	<table width="100%" class="rows">
		<tr>
			<td><strong>Omschrijving</strong></td>
			<td><strong><small>Status</small></strong></td>
			<td><strong><small>Prijs</small></strong></td>
			<td><strong><small>Datum</small></strong></td>
		</tr>
		
		{{article-row}}
	</table>
</div>


{{workorder-row}}