<header>
    <div class="container">
        <h1>$Title</h1>
    </div>
</header>
<section class="container">
    <article>
        <section>$Content</section>
        <h2>Sections</h2>
        <section>
            <% if $Sections %>
                <dl>
                    <% loop $Sections %>
                        <dt>$Title</dt>
                        <dd>$Info</dd>
                    <% end_loop %>
                </dl>
            <% end_if %>
        </section>
    </article>


    <aside class="Widgetbar">
    <section class="WidgetHolder">
        <div>
            <figure>
                $Necker
                <figcaption>$NeckerDescription</figcaption>
            </figure>
        </div>
    </section>
    <section class="WidgetHolder">
        <div>
            <h3>Contact Info</h3>
            <p>
            <% if $Address1 %><span>$Address1</span><br /><% end_if %>
            <% if $Address2 %><span>$Address2</span><br /><% end_if %>
            <% if $Address3 %><span>$Address3</span><br /><% end_if %>
            <% if $Town %><span>$Town</span><br /><% end_if %>
            <% if $Postcode %><span>$Postcode</span><br /><% end_if %>
                <br />
            <% if $Phone %><span>$Phone</span><br /><% end_if %>
            <% if $Email %><span><a href="mailto:$Email">$Email</a></span><br /><% end_if %>
                <br />
            <% if $CharityNumber %><span><a href="http://apps.charitycommission.gov.uk/Showcharity/RegisterOfCharities/CharityWithoutPartB.aspx?RegisteredCharityNumber=$CharityNumber">Charity Reg #$CharityNumber</a></span><% end_if %>
            </p>
        </div>
    </section>

    </aside>
</section>