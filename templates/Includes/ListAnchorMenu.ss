<% if $PublicList %>
	<ul class="list-anchor-menu {$ListClass}">
		<% loop $PublicList %>
			<li <% if $First %>class="first"<% end_if%> <% if $Last %>class="last"<% end_if %> ><a href="#{$NamedAnchor}" title="{$ItemTitle}">$ItemTitle</a></li>
		<% end_loop %>
	</ul>
<% end_if %>