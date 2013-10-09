<div id="$Name" class="field<% if extraClass %> $extraClass<% end_if %>">
	<% if Title %><label class="left" for="$ID">$Title</label><% end_if %>
    <span class="activesort"><% _t("SortableUploadField.ACTIVESORT","Allow Drag and Drop") %></span>
	<div class="middleColumn">
		$Field
	</div>
	<% if RightTitle %><label class="right" for="$ID">$RightTitle</label><% end_if %>
	<% if Message %><span class="message $MessageType">$Message</span><% end_if %>
</div>