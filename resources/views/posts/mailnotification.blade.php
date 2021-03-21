<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
</head>
<body>
    <h1>New Reply to your post</h1>
    <br>
    Dear {{ $postUsername }}!
    <p>{{ $replyUsername }} replied to your post:</p>
    <p>Post-Title: {{ $postTitle }}</p> 
    <p>Post-Content: {{ $postContent }}</p>
    <p>Reply:</p>
    <pre>{{ $replyContent }}</pre>
    <p>We wish you a nice day - your Codemeetup-Forum Team.</p>
</body>
</html>