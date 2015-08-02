<header>
    <div class="container">
        <h1>$Title</h1>
    </div>
</header>
<section class="container">
    <article>
        <section>$Content</section>
    </article>


    <aside class="Widgetbar">

        <% if $Logo %>
            $Logo
        <% end_if %>

        <% if $Promise %>
        <section class="WidgetHolder">
            <div>
                <h3>Promise</h3>
                <div>
                $Promise
                </div>
            </div>
        </section>
        <% end_if %>
        <% if $Law %>
            <section class="WidgetHolder">
                <div>
                    <h3>Law</h3>
                    <div>
                    $Law
                    </div>
                </div>
            </section>
        <% end_if %>
        <% if $Motto %>
            <section class="WidgetHolder">
                <div>
                    <h3>Motto</h3>
                    <div>
                    $Motto
                    </div>
                </div>
            </section>
        <% end_if %>

        <% if $Groups %>
            <section class="WidgetHolder">
                <div>
                    <h3>Our $SectionLabel</h3>
                    <ul>
                        <% loop $Groups %>
                            <li><a href="$Link" title="$Title">$Title</a></li>
                        <% end_loop %>
                    </ul>
                </div>
            </section>

        <% end_if %>

    </aside>
</section>