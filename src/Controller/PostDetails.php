<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model;

class PostDetails extends Controller
{
    private ?Model\Post $post = null;

    public function getContext(): Context
    {
        $context = new Context();

        if ($this->post === null) {
            $context->title = 'Not Found';
            $context->content = "A post with id {$this->params[0]} was not found.";
        } else {
            $context->title = $this->post->title;
        }

        return $context;
    }

    public function getTemplate(): Template\Template
    {
        if ($this->post === null) {
            return new Template\NotFound();
        }

        return new Template\PostDetails();
    }

    public function getStatus(): string
    {
        if ($this->post === null) {
            return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        }

        return $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
    }

    protected function loadData(): void
    { // Get the post ID from the URL parameter
        $postId = $this->params[0] ?? null;
        
        // If no post ID is provided, set $this->post to null and return
        if ($postId === null) {
            $this->post = null;
            return;
        }

        // Fetch the post from the database based on the ID
        $post = Model\Post::findPublishedById($postId);

        // If the post is found, assign it to $this->post
        if ($post !== null) {
            $this->post = $post;
        }
    }
}
