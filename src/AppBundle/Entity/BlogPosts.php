<?php

// src/AppBundle/Entity/BlogPost.php

// ...
class BlogPosts
{
    // ...

    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="blogPosts")
     */
    private $category;

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    // ...
}