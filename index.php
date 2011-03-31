<pre><?php
// Sorbet index file
require "framework/core.php";
print_r(Post::getBlob(1));

$posts = Post::getPosts();
print_r($posts);