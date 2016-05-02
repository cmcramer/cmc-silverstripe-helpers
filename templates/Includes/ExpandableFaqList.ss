<% if $Faqs %>
	<h2>$ListTitle</h2>
	<p><a id="TJK_ToggleON" 
			href="/sculling/elite-sculling/about-the-sbtc-program/#" 
			class="ss-broken">Expand All FAQ</a> 
	 		| 
	 	<a id="TJK_ToggleOFF" 
	 		href="/sculling/elite-sculling/about-the-sbtc-program/#" 
	 		class="ss-broken">Collapse All FAQ</a></p>
	<dl id="TJK_DL">
		<% loop $Faqs %>
			<dt>$Question</dt>
			<dd>$Answer</dd>
		<% end_loop %>
	</dl>
	$ToggleJsInit
<% end_if %>
