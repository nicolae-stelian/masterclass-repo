<?php

namespace Upvote\Controllers;

use Upvote\Exceptions\UserNotAuthenticatedException;

class CommentController extends Controller
{
    public function create()
    {
        if (!$this->isAuthenticated()) {
            throw new UserNotAuthenticatedException();
        }

        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                 $this->getUserName(),
                 $this->getStoryId(),
                 $this->validatePost('comment'),
            )
        );
        header("Location: /story/?id=" . $this->getStoryId());
    }

    protected function isAuthenticated()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            return false;
        }
        return true;
    }


    protected function getUserName()
    {
        return $_SESSION['username'];
    }

    /**
     * @return mixed
     */
    protected function getStoryId()
    {
        return $_POST['story_id'];
    }

    /**
     * @return mixed
     */
    protected function validatePost($field)
    {
        return filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}
