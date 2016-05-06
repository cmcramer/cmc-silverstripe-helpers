<% if $PublicList %>
	<ul class="list-jump-menu {$ListClass}">
		<% loop $PublicList %>
			<li><a href="#{$NamedAnchor}" title="{$ItemTitle}">$ItemTitle</a></li>
		<% end_loop %>
	</ul>
<% end_if %>