<?php

namespace silverorange\DevTest\Model;
use silverorange\DevTest\Database;

class Post
{
    public string $id;
    public string $title;
    public string $body;
    public string $created_at;
    public string $modified_at;
    public string $author;

 // Method to fetch all posts from the database
 // Method to fetch all posts from the database in chronological order
 public static function getAll(): array
 {
     $db = Database::getInstance(); // Assuming you have a method to get a database connection instance
     $connection = $db->getConnection(); // Get the PDO connection object

     $query = "SELECT * FROM posts ORDER BY created_at ASC"; // Order by creation date in ascending order
     $statement = $connection->query($query); // Execute the query

     $posts = [];
     while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
         // Create a new Post object for each row and populate its properties
         $post = new Post();
         $post->id = $row['id'];
         $post->title = $row['title'];
         $post->body = $row['body'];
         $post->created_at = $row['created_at'];
         $post->modified_at = $row['modified_at'];
         $post->author = $row['author'];

         $posts[] = $post; // Add the Post object to the array
     }

     return $posts; // Return the array of Post objects
 }

    public static function findPublishedById(string $id): ?self
    {
        // Perform a database query to fetch the post with the specified ID
        $query = "SELECT * FROM posts WHERE id = :id AND published = 1"; // Assuming there's a 'published' column
        
        // Prepare the query
        $statement = Database::getInstance()->prepare($query);

        // Bind the ID parameter
        $statement->bindValue(':id', $id, \PDO::PARAM_STR);

        // Execute the query
        $statement->execute();

        // Fetch the result
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        // If no result is found, return null
        if (!$result) {
            return null;
        }

        // Create a new Post object and populate its properties
        $post = new self();
        $post->id = $result['id'];
        $post->title = $result['title'];
        $post->body = $result['body'];
        $post->created_at = $result['created_at'];
        $post->modified_at = $result['modified_at'];
        $post->author = $result['author'];

        return $post;
    }
}
