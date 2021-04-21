<form action="/sender" method="post">
    <input type="text" name="content">
    <input type="text" name="for_user_id">
    <input type="submit">
    {{CSRF_FIELD()}}
</form>
