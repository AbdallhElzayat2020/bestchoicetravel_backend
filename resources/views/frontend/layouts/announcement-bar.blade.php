{{-- One line scrolls in from the right, exits left, then repeats (no duplicate on screen) --}}
@if ($sharedAnnouncementBar)
    <div id="announcement-bar" class="announcement-bar" role="region" aria-label="Announcement">
        <div class="announcement-bar__mask">
            <div class="announcement-bar__track" id="announcementBarTrack">
                <div class="announcement-bar__loop">
                    <span class="announcement-bar__text">{{ $sharedAnnouncementBar->content }}</span>
                </div>
            </div>
        </div>
    </div>
@endif
