<div class="container">

    $Content
    <h1>$Title</h1>
    <% if $Leaders %>
        <% loop $Leaders %>
            <p>Title: $Title</p>
        <% end_loop %>
    <% end_if %>
    $Form
</div>