<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Post;
use Authorization\IdentityInterface;

/**
 * Post policy
 */
class PostPolicy
{
    /**
     * Check if $user can create Post
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $post
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Post $post)
    {
    }

    /**
     * Check if $user can update Post
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $post
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Post $post)
    {
      return $user->id === $post->user_id;

    }

    /**
     * Check if $user can delete Post
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $post
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Post $post)
    {
      return $user->id === $post->user_id;

    }

    /**
     * Check if $user can view Post
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Post $post
     * @return bool
     */
    public function canView(IdentityInterface $user, Post $post)
    {
    }
}
