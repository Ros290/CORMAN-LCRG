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
                                                        <data class="number" value=""></data>
                                                        <span class="caption">Indice</span>
                                                        <span class="tooltip right medium" id="desch-index" role="tooltip">
                                                        </span></li>
                                                    <li class="stat-box with-tooltip stat-citations" tabindex="0" aria-describedby="descCitations" aria-label="Citations = 401">
                                                        <data class="number" value=""></data>
                                                        <span class="caption">Citazioni</span>
                                                        <span class="tooltip right medium" id="descCitations" role="tooltip">
                                                        </span></li></ul></section></div></div>
                            </div></div></section></div></div>
        </div>
    </div>
</div>
<div id="profile-secondary-navigation-react">
    <div id="profile-secondary-navigation" class="secondary-navigation" data-reactroot="">
        <div class="card">
            <div class="with-container">
                <div class="section-list horizontal">
                    <div class="transparent-ends">
                        <ul>
                            <li class="profile-secondary-navigation-tab active">
                                <a href="generale" title="Generale" id="profile-overview">Generale</a></li>
                            <li class="profile-secondary-navigation-tab">
                                <a href="statistiche/" title="Statistiche" id="profile-stats">Statistiche</a></li>
                            <li class="profile-secondary-navigation-tab">
                                <a href="/network/" title="Network" id="profile-network">Network</a></li>
                        </ul></div></div></div></div></div></div>
<div class="with-container content">
    <div id="profile-page">
        <div class="with-container content" data-reactroot="">
            <div class="row">
                <div class="column d-1-3 m-5-12 s-1-1 xs-1-1" id="profile-page-left-column">
                    <div><div class="card" id="profile-connections">
                            <header><h2>Altri ID</h2></header>
                            <section><section class="connections-content">
                                    <div></div>
                                    <div><div class="scopus-content">
                                            <h4>Scopus</h4>
                                            <ul class="bare-list" id="scopus-author-id-list">
                                                <li data-author-id="23392182500">
                                                    <div class="row">
                                                        <div class="column d-1-1 ">
                                                            <a class="basic-link" href="" target="_blank" rel="noopener noreferrer">Author ID: </a></div></div></li></ul></div></div></section></section></div>
                        <div class="card" id="profile-interests">
                            <header><h2>Interessi di ricerca</h2></header>
                            <section><div class="expandable-wrap expandable-with-buttons">
                                    <div style="height: auto;" class="expandable-content ">
                                        <span class="tag">
                                        </span></div></div></section></div>
                        <div class="card" id="profile-biography">
                            <header><h2>About</h2></header>
                            <section><div class="expandable-wrap expandable-with-buttons">
                                    <div style="height:96px" class="expandable-content ">
                                        <div class="with-container content">
                                            <div id="profile-page">
                                                <div class="with-container content" data-reactroot="">
                                                    <div class="row">
                                                        <div class="column d-1-3 m-5-12 s-1-1 xs-1-1" id="profile-page-left-column">
                                                            <div><div class="card" id="profile-connections">
                                                                    <header><h2>Altri ID</h2></header>
                                                                    <section><section class="connections-content">
                                                                            <div></div>
                                                                            <div><div class="scopus-content">
                                                                                    <h4>Scopo</h4>
                                                                                    <ul class="bare-list" id="scopus-author-id-list">
                                                                                        <li data-author-id="23392182500">
                                                                                            <div class="row">
                                                                                                <div class="column d-1-1 ">
                                                                                                    <a class="basic-link" href= "" target="_blank" rel="noopener noreferrer">Author ID: </a></div></div></li></ul></div></div></section></section></div>
                                                                <div class="card" id="profile-interests">
                                                                    <header><h2>Interessi di ricerca</h2></header>
                                                                    <section><div class="expandable-wrap expandable-with-buttons">
                                                                            <div style="height: auto;" class="expandable-content ">
                                                                                <span class="tag"></span></div></div></section></div>
                                                                <div class="card" id="profile-biography">
                                                                    <header><h2>About</h2></header>
                                                                    <section>
                                                                        <div class="expandable-wrap expandable-with-buttons">
                                                                            <div style="height:96px" class="expandable-content ">
                                                                                </div>
                                                                            <button class="basic-link with-icon-before icon-navigatedown">
                                                                                <span>

                                                                                </span></button></div></section></div>
                                                                <div class="card" id="profile-groups">
                                                                    <header><h2>Gruppi
                                                                        </h2></header>
                                                                    <section><ul class="Groups__GroupList-s1api6o4-1 cTKYIU">
                                                                            <li class="Groups__GroupListItem-s1api6o4-2 jOZVYi">
                                                                                <div class="Groups__Avatar-s1api6o4-3 PNpVh">
                                                                                    <a href=title="Entity>
                                                                                        <img src="" alt=""></a></div>
                                                                                <div class="Groups__InfoWrapper-s1api6o4-4 eodCSb">
                                                                                    <a href="" title=""></a>
                                                                                    <div class="Metadata-s1pq3t4v-0 hdvYIM">
                                                                                        </div></div></li></ul></section></div>
                                                                <div><div class="card" id="profile-co-authors">
                                                                        <header class="co-authors-header">
                                                                            <h2>Altri autori <!-- --></h2></header>
                                                                        <section class="co-authors-content">
                                                                            <div class="follower-list with-small-images">
                                                                                <ul><li class="co-authors-network-list">
                                                                                        <a href="" title="">
                                                                                            <img src= alt=></a>
                                                                                        <div class="co-author-info ">
                                                                                            <h5><a href= title=></a>
                                                                                                <span class="with-tooltip">
                                                                                                    <span class="tooltip small left">
                                                                                                        </span></span></h5>
                                                                                            <span class=</span></div>
                                                                                        <button type="button" class="basic-link with-icon-after icon-followuser follow-states" data-state="follow">
                                                                                            <span class="button-text-follow">Segui</span>
                                                                                            <span class="button-text-following">Seguiti</span>
                                                                                            <span class="button-text-unfollow">Non seguiti</span>
                                                                                            <span class="button-text-pending">Pending</span>
                                                                                            <span class="button-text-cancel">Cancella</span></button></li>
                                                                            </div>
</body>
</html>