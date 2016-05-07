<% if PublicList %>
	<h2>$ListTitle</h2>
	<% if $TopAnchorMenu %>
		<% include ListAnchorMenu %>
	<% end_if %>
	<dl class="stacked-list $ListClass">
		<% loop $PublicList %>
			<a name="{$NamedAnchor}"></a>
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
	<% if $BottomAnchorMenu %>
		<% include ListAnchorMenu %>
	<% end_if %>
<% end_if %>
