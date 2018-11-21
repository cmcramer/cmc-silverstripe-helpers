<% if PublicList %>
	<h2>$ListTitle</h2>
	<p><a id="TJK_ToggleON" 
			href="/sculling/elite-sculling/about-the-sbtc-program/#" 
			class="ss-broken">Expand All $ExpandCollapseLabel</a> 
	 		| 
	 	<a id="TJK_ToggleOFF" 
	 		href="/sculling/elite-sculling/about-the-sbtc-program/#" 
	 		class="ss-broken">Collapse All $ExpandCollapseLabel</a></p>
	<dl id="TJK_DL">
		<% loop $PublicList %>
            <a name="$ItemAnchorName" id="$ItemAnchorName" />
			<dt id="$ItemAnchorName" >$ItemTitle</dt>
			<dd>
				<% if $Image %>
					<a class="fancybox" title="{$Image.Title}" 
						href="{$Image.FitMax(1200,800).Link}" rel="fancyboxgroup">
  						{$Image.CroppedImage(120,120)}
					</a>
				<% end_if %>
				$ItemContent</dd>
		<% end_loop %>
	</dl>
	$ListNotes
	$ToggleJsInit
<% end_if %>
