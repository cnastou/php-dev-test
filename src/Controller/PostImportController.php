<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model;
use PDO;

class PostImportController
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function importPostsFromFiles()
    {
        // Get list of post files
        $postFiles = glob('data/*.json');

        foreach ($postFiles as $postFile) {
            // Read JSON content from each file
            $jsonData = file_get_contents($postFile);

            // Decode JSON data
            $postData = json_decode($jsonData, true);

            // Insert post into the database
            $this->insertPost($postData);

            echo "Post imported: {$postData['title']}\n";
        }

        echo "All posts imported successfully.\n";
    }

    protected function insertPost(array $postData)
    {
        $stmt = $this->pdo->prepare("INSERT INTO posts (title, body, created_at, modified_at, author_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$postData['title'], $postData['body'], $postData['created_at'], $postData['modified_at'], $postData['author']]);
    }
}
