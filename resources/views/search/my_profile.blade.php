<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Il mio profilo </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <h1> Il mio profilo </h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
@endif
    <div class="headline">
        <div class="with-container">
            <div id="top-card-react">
                <div class="card-details" id="profile-details" data-reactroot=""><section class="bio">
                        <div class="summary card summary-edit">
                            <div class="row">
                                <div class="column d-2-3 m-3-4 s-1-1 xs-1-1">
                                    <div class="summary-left"><aside class="details-photo">
                                            <div class="image-box"><img  alt="Profile Picture" class="large-image">
                                            </div></aside>
                                        <section class="details-content">
                                            <div class="summary-nested">
                                                <ul class="bare-list bio-nested">
                                                  </ul></div></section></div></div>
                                <div class="column d-1-3 m-1-4 s-1-1 xs-1-1 stats-column">
                                    <div class="row"><div class="column d-1-1"><section class="statistics-content">
                                                <ul class="stat-group clearfix" aria-label="author metrics">
                                                    <li class="stat-box with-tooltip stat-hindex" tabindex="0" aria-describedby="desch-index" aria-label="h-index = 9">
                                                        <data class="number" value="9">9</data>
                                                        <span class="caption">h-index</span>
                                                        <span class="tooltip right medium" id="desch-index" role="tooltip">
                                                        </span></li>
                                                    <li class="stat-box with-tooltip stat-citations" tabindex="0" aria-describedby="descCitations" aria-label="Citations = 401">
                                                        <data class="number" value="401">401</data>
                                                        <span class="caption">Citations</span>
                                                        <span class="tooltip right medium" id="descCitations" role="tooltip">
                                                        </span></li></ul></section></div></div>
                                    <div class="row"><div class="column d-1-1">
                                            <div class="button-group-actions">
                                                <div class="button-group">
                                                    <button type="button" class="button-primary with-icon-after icon-followuser follow-states" data-state="follow">
                                                        <span class="button-text-follow">Follow</span>
                                                        <span class="button-text-following">Following</span>
                                                        <span class="button-text-unfollow">Unfollow</span>
                                                        <span class="button-text-pending">Pending</span>
                                                        <span class="button-text-cancel">Cancel</span>
                                                    </button></div></div></div></div></div>
                            </div></div></section></div></div>
        </div>
    </div>
</div>
</body>
</html>