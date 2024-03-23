<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model\Post;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        $postsHtml = '';

        // Iterate over each post in the context and generate HTML
        foreach ($context->posts as $post) {
            $postsHtml .= $this->renderPost($post);
        }

        // Construct the HTML for displaying all posts
        $html = '<div class="post-list">' . $postsHtml . '</div>';

        return $html;
    }

    private function renderPost(Post $post): string
    {
        // Generate HTML for a single post
        $html = '<div class="post">';
        $html .= '<h2>' . htmlspecialchars($post->title) . '</h2>';
        $html .= '<p class="author">Author: ' . htmlspecialchars($post->author) . '</p>';
        $html .= '<div class="body">' . $this->renderMarkdown($post->body) . '</div>';
        $html .= '</div>';

        return $html;
    }

    private function renderMarkdown(string $markdown): string
    {
        // Convert Markdown to HTML using a Markdown parser (you need to implement this method)
        // Example: return \MarkdownParser::parse($markdown);
        // For this example, let's assume we have a Markdown parser class named MarkdownParser
        return MarkdownParser::parse($markdown);
    }
}
