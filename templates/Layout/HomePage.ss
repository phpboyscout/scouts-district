<% with $BackgroundImage %>
<header style="background-image: url($getRelativePath())">
<% end_with %>
    <% if $FocalImageLeft %>
    <img id="focal-image-left" src="$FocalImageLeft.getRelativePath()" />
    <% end_if %>
    <% if $FocalImageCentre %>
    <img id="focal-image-centre" src="$FocalImageCentre.getRelativePath()" />
    <% end_if %>
    <% if $FocalImageRight %>
    <img id="focal-image-right" src="$FocalImageRight.getRelativePath()" />
    <% end_if %>
    <% with $ForegroundImage %>
    <div class="foreground" style="background-image: url($getRelativePath())">
    <% end_with %>
        <div class="container">
            <div class="tagline">
                <% if $FirstTagLine %>
                <span>$FirstTagLine</span>
                <% end_if %>
                <% if $SecondTagLine %>
                <span>$SecondTagLine.</span>
                <% end_if %>
                <% if $TagLinkText %>
                <div>
                    <a href="$TagLink()" title="$TagLinkText">$TagLinkText</a>
                </div>
                <% end_if %>
            </div>
        </div>
    </div>
</header>

<section id="events">
    <div class="container">

        <section class="next-event">
            <div class="content">

                <h3>OUR NEXT EVENT&hellip;</h3>
                <article>
                    <% if $NextEvent.ClassName = "CalendarDateTime" %>
                        <% with $NextEvent %>
                            <time datetime="$StartDate $StartTime">$StartDate.format('jS M, Y') $StartTime.format('@ H:i')</time>
                            <header>
                                <a href="$Event.Link">$Event.Title</a>
                            </header>
                            <p>
                                $Event.Content.LimitWordCount(16)
                                <a class="more" href="$Event.Link" title="<% _t('FIND_OUT_MORE', 'Find out more') %>"><% _t('FIND_OUT_MORE', 'Find out more') %></a>
                            </p>
                        <% end_with %>
                    <% else %>
                        <p><% _t('NOTHING_PLANNED_YET', 'Nothing planned yet') %>&hellip;</p>
                    <% end_if %>
                </article>

            </div>
        </section>

        <section class="coming-up">
            <div class="content">

                <h3>COMING UP&hellip;</h3>
                <article>
                    <% if $UpcomingEvent.ClassName = "CalendarDateTime" %>
                        <% with $UpcomingEvent %>
                            <time datetime="$StartDate $StartTime">$StartDate.format('jS M, Y') $StartTime.format('@ H:i')</time>
                            <header>
                                <a href="$Event.Link">$Event.Title</a>
                            </header>
                            <p>
                                $Event.Content.LimitWordCount(16)
                                <a class="more" href="$Event.Link" title="<% _t('FIND_OUT_MORE', 'Find out more') %>"><% _t('FIND_OUT_MORE', 'Find out more') %></a>
                            </p>
                        <% end_with %>
                    <% else %>
                        <p><% _t('NOTHING_PLANNED_YET', 'Nothing planned yet') %>&hellip;</p>
                    <% end_if %>
                </article>

            </div>
        </section>

    </div>
</section>

<section id="about-us">
    <div class="container">
        <article>
            <% with $InfoPanelPage() %>
                <div class="content">
                    <header>$Title</header>
                    <p>$Content.LimitWordCount(60)</p>
                    <a href="$Link" class="readmore" title="<% _t('READ_MORE', 'Read more') %>"><% _t('READ_MORE', 'Read more') %><i class="icon-arrow-readmore"></i></a>
                </div>
            <% end_with %>
        </article>
        $InfoPanelImage
    </div>
</section>

<section id="additional">
    <div class="inner">

        <section id="calendar">
            <div class="content">

                <h2><a href="/events">Calendar</a></h2>
                <% if $CalendarEvents %>
                    <% loop $CalendarEvents %>
                        <article>
                            <% if $Event.ThumbnailImage %><a href="$Event.Link">$Event.ThumbnailImage.setWidth(100)</a><% end_if %>
                            <div class="details">
                                <time datetime="$StartDate $StartTime">$StartDate.format('jS M, Y')<% if $StartDate %>@ $getFormattedStartTime()<% end_if %></time>
                                <h4><a href="$Event.Link">$Event.Title</a></h4>
                                <% if $Event.EventLocation %>
                                <p>$Event.EventLocation</p>
                                <% end_if %>
                            </div>
                            </article>
                        <% end_loop %>
                    <% else %>
                        <article>
                            <p><% _t('NOTHING_PLANNED_YET', 'Nothing planned yet') %>&hellip;</p>
                        </article>
                    <% end_if %>

                </div>
            </section>

            <section id="news">
                <div class="content">
                    <h2><a href="/news">News</a></h2>
                    <% if $LatestNews %>
                        <% loop $LatestNews %>
                            <article>
                                <h3 class="postTitle">
                                    <% if ClassName = ExternalBlogEntry %>
                                    <a href="$ExternalLink" target="_blank" title="<% _t('VIEW_FULL_POST_TITLED', 'View full post titled -') %> '$Title'">$MenuTitle</a>
                                    <% else %>
                                        <a href="$Link" title="<% _t('VIEW_FULL_POST_TITLED', 'View full post titled -') %> '$Title'">$MenuTitle</a>
                                    <% end_if %>
                                </h3>
                                <p>$Content.FirstParagraph(html)</p>
                                <% if ClassName = ExternalBlogEntry %>
                                    <a href="$ExternalLink" target="_blank" class="readmore" title="<% _t('READ_MORE', 'Read more') %>"><% _t('READ_MORE', 'Read more') %><i class="icon-arrow-readmore"></i></a>
                                <% else %>
                                    <a href="$Link" class="readmore" title="<% _t('READ_MORE', 'Read more') %>"><% _t('READ_MORE', 'Read more') %><i class="icon-arrow-readmore"></i></a>
                                <% end_if %>
                            </article>
                        <% end_loop %>
                    <% else %>
                        <p><% _t('STAYED_TUNED_FOR_MORE_NEWS', 'Stay tuned for more news') %>&hellip;</p>
                    <% end_if %>
                </div>
            </section>

        </div>
    </section>
