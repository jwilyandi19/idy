{% extends 'layout.volt' %}

{% block title %}Add New Idea{% endblock %}

{% block styles %}
<style>
body{
    font-family:arial,sans-serif;
    font-size:100%;
    margin:3em;
    background:#666;
    color:#fff;
}
</style>
{% endblock %}

{% block content %}
<div style="margin-top:100px">
    <form method="POST">
        <h3>Author</h3>
        <div class="form-group">
            <label class="font-weight-bold">Name</label>
            <input type="text" class="form-control" placeholder="Enter name" name="author_name">
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Email</label>
            <input type="email" class="form-control" placeholder="Enter email" name="author_email">
        </div>
        <h3>Idea</h3>
        <div class="form-group">
            <label class="font-weight-bold">Title</label>
            <input type="text" class="form-control" placeholder="Enter title" name="title">
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Description</label>
            <textarea type="text" rows="5" class="form-control" placeholder="Description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


{% endblock %}

{% block scripts %}

{% endblock %}