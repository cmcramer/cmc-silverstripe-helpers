<% if $PublicFaq %>
	<h2>$ListTitle</h2>
	<p><a id="TJK_ToggleON" 
			href="/sculling/elite-sculling/about-the-sbtc-program/#" 
			class="ss-broken">Expand All FAQ</a> 
	 		| 
	 	<a id="TJK_ToggleOFF" 
	 		href="/sculling/elite-sculling/about-the-sbtc-program/#" 
	 		class="ss-broken">Collapse All FAQ</a></p>
	<dl id="TJK_DL">
		<% loop $PublicFaq %>
			<dt>$ItemTitle</dt>
			<dd>
				<% if $Image %>
					<a class="fancybox" title="{$Image.Title}" 
						href="{$Image.FitMax(1200,800).Link}" rel="fancyboxgroup">
  						{$Image.CroppedImage(120,100)}
					</a>
				<% end_if %>
			$ItemContent</dd>
		<% end_loop %>
	</dl>
	$ListNotes
	$ToggleJsInit
<% end_if %>
