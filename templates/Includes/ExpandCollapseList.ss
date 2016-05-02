<% if ExpandCollapseListItems %>
	<h2>$ListTitle</h2>
	<p><a id="TJK_ToggleON" 
			href="/sculling/elite-sculling/about-the-sbtc-program/#" 
			class="ss-broken">Expand All $ExpandCollapseLabel</a> 
	 		| 
	 	<a id="TJK_ToggleOFF" 
	 		href="/sculling/elite-sculling/about-the-sbtc-program/#" 
	 		class="ss-broken">Collapse All $ExpandCollapseLabel</a></p>
	<dl id="TJK_DL">
		<% loop $ExpandCollapseListItems %>
			<dt>$ItemTitle</dt>
			<dd>$ItemContent</dd>
		<% end_loop %>
	</dl>
	$ToggleJsInit
<% end_if %>