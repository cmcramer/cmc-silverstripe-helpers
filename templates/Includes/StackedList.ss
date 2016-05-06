<% if PublicList %>
	<h2>$ListTitle</h2>
	<dl class="stacked-list $ListClass">
		<% loop $PublicList %>
			<dt>$ItemTitle</dt>
			<dd>
				<% if $Image %>
					<a class="fancybox" title="{$Image.Title}" 
						href="{$Image.FitMax(1200,800).Link}" rel="fancyboxgroup">
  						{$Image.CroppedImage($Up.ThumbnailWidth,$Up.ThumbnailHeight)}
					</a>
				<% end_if %>
				$ItemContent</dd>
		<% end_loop %>
	</dl>
	$ListNotes
<% end_if %>
