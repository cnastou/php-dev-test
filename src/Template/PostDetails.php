<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {
         $context->getPostId();
         // Load the post from the database
         $post = Post::findPublishedById($postId);

         if ($post === null) {
             // @codingStandardsIgnoreStart
             return <<<HTML
                    <p>Post not found</p>
                    HTML;
             // @codingStandardsIgnoreEnd
         }
         else {
             // @codingStandardsIgnoreStart
             return <<<HTML
                    <h1>{$post->getTitle()}</h1>
                    <p>{$post->getContent()}</p>
                    HTML;
             // @codingStandardsIgnoreEnd
         }
    }
}
