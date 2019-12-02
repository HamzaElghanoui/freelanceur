<?php
// ...
use Doctrine\Common\Collections\ArrayCollection;
// ...

class Categories
{
    // ...

    /**
    * @ORM\OneToMany(targetEntity="BlogPosts", mappedBy="category")
    */
    private $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function getBlogPosts()
    {
        return $this->blogPosts;
    }

    // ...
}