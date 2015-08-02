<header>
    <div class="container">
        <h1>$Title</h1>
    </div>
</header>

<section>
    <article>
        $Content
    </article>

    <% if $Children %>
        <nav>
        <% loop $Children %>
            <h2><a href="$Link"><% if $Badge %>$Badge.SetHeight(70) <% end_if %>$Title</a></h2>
        <% end_loop %>
        </nav>
    <% end_if %>
    $Form
</section>