{% extends 'layout.volt' %}

{% block title %}Rate Idea{% endblock %}

{% block styles %}
<style>
    body{
        font-family:arial,sans-serif;
        font-size:100%;
        margin:3em;
        background:#666;
        color:#fff;
    }
    h2,p{
        font-size:100%;
        font-weight:normal;
        color: black;
    }
    ul,li{
        list-style:none;
    }
    ul{
        overflow:hidden;
        padding:3em;
    }
     .sticky {
        text-decoration:none;
        color:#000;
        background:#f6ff7a;
        display:block;
        height:15em;
        width:15em;
        padding:1em;
        -moz-box-shadow:5px 5px 7px rgba(33,33,33,1);
        /* Safari+Chrome */
        -webkit-box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        /* Opera */
        box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        -moz-transition:-moz-transform .15s linear;
        -o-transition:-o-transform .15s linear;
        -webkit-transition:-webkit-transform .15s linear;
    }
    {
        margin:1em;
        float:left;
    }
     h2{
        font-size:140%;
        font-weight:bold;
        padding-bottom:10px;
    }
     p{
        font-family:"Reenie Beanie",arial,sans-serif;
    }
    :nth-child(even) .sticky {
        -o-transform:rotate(4deg);
        -webkit-transform:rotate(4deg);
        -moz-transform:rotate(4deg);
        position:relative;
        top:5px;
    }
    :nth-child(3n) .sticky {
        -o-transform:rotate(-3deg);
        -webkit-transform:rotate(-3deg);
        -moz-transform:rotate(-3deg);
        position:relative;
        top:-5px;
        background:#f26b6b;
    }
    :nth-child(5n) .sticky {
        -o-transform:rotate(5deg);
        -webkit-transform:rotate(5deg);
        -moz-transform:rotate(5deg);
        position:relative;
        top:-10px;
        background: #6bbcf2;
    }
    .sticky:hover, .sticky:focus{
        -moz-box-shadow:10px 10px 7px rgba(0,0,0,.7);
        -webkit-box-shadow: 10px 10px 7px rgba(0,0,0,.7);
        box-shadow:10px 10px 7px rgba(0,0,0,.7);
        -webkit-transform: scale(1.25);
        -moz-transform: scale(1.25);
        -o-transform: scale(1.25);
        position:relative;
        z-index:5;
    }
</style>

{% endblock %}

{% block content %}
<div class="sticky" style="margin-top:100px">
        <h2>{{ idea.title() }}</h2>
        <p> {{ idea.description() }}</p>
        <div class="author">By {{ idea.author().name() }}</div>
        <div class="email">{{ idea.author().email() }}</div>
        <div class="rating">Ratings: {{ idea.averageRating()}} <a href="{{ url('idea/rate/') }}{{ idea.id().id() }}">Rate</a></div>
        <div class="rating">Votes: {{ idea.votes() }} <a href="{{ url('idea/vote/') }}{{ idea.id().id() }}">Vote</a></div>
    </div>
    
    <div class="container bg-white text-dark p-2 rounded" style="margin-top: 20px">
        <div class="h4 font-weight-bold"> Give Rating </div>
        <form method="POST" class="form-inline">
            <div class="form-group mr-2">
                <label class="font-weight-bold mx-1">Name</label>
                <input type="text" class="form-control" placeholder="Enter name" name="name">
            </div>
            <div class="form-group mr-2">
                <label class="font-weight-bold mx-1">Rating</label>
                <select class="form-control form-control-sm" name="rating">
                    <option value=1 >1</option>
                    <option value=2 >2</option>
                    <option value=3 >3</option>
                    <option value=4 >4</option>
                    <option value=5 >5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    
    <div class="container" style="margin-top:30px;">
        <div class="row">
          {% for rating in idea.ratings() %}
          <div class="col-sm-2 border border-dark text-dark bg-white rounded p-2">
              <div class="font-weight-bold">{{ rating.user() }}</div>
              Rating : {{ rating.value() }}
          </div>
          {% endfor %}
        </div>
    </div>


{% endblock %}

{% block scripts %}

{% endblock %}