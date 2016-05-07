<% if PublicList %>
	<h2>$ListTitle</h2>
	<% if $TopAnchorMenu %>
		<% include ListAnchorMenu %>
	<% end_if %>
	<dl class="stacked-list $ListClass">
		<% loop $PublicList %>
			<a name="{$NamedAnchor}"></a>
			<dt <% if $StartNewSection %>class="new-section"<% end_if %>
				<% if $ItemUrl %><a href="{$ItemUrl.LinkURL}" title="$ItemTitle">$ItemTitle</a>
				<% else %>$ItemTitle<% end_if %></dt>
			<dd>
				<% if $Image %>
					<p <% if $ThumbnailsOnRight %>class="float-right"<% else %>class="float-left"<% end_if %>>
						<% if $ItemUrl %>
							<a title="{$ItemTitle}" href="{$ItemUrl.LinkURL}">
		  						{$Image.CroppedImage($Up.ThumbnailWidth,$Up.ThumbnailHeight)}
							</a>
						<% else %>
							<a class="fancybox" title="{$ItemTitle}" 
								href="{$Image.FitMax(1200,800).Link}" rel="fancyboxgroup">
		  						{$Image.CroppedImage($Up.ThumbnailWidth,$Up.ThumbnailHeight)}
							</a>
						<% end_if %>
					</p>
				<% end_if %>
				$ItemContent</dd>
		<% end_loop %>
	</dl>
	$ListNotes
	<% if $BottomAnchorMenu %>
		<% include ListAnchorMenu %>
	<% end_if %>
<% end_if %>
