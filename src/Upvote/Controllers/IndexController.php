<?php

namespace Upvote\Controllers;


class IndexController extends Controller
{


    public function index()
    {

        $stories = $this->getAllStories();

        $content = '<ol>';

        foreach ($stories as $story) {
            $count = $this->countComments($story);
            $content .= $this->generateStoryHtml($story, $count);
        }

        $content .= '</ol>';

        require_once __DIR__ . '/../Views/layout.phtml';
    }

    /**
     * @return array
     */
    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $stories;
    }

    /**
     * @param $story
     *
     * @return mixed
     */
    public function countComments($story)
    {
        $sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($sql);
        $comment_stmt->execute(array($story['id']));
        $count = $comment_stmt->fetch(\PDO::FETCH_ASSOC);
        return $count;
    }

    /**
     * @param $story
     * @param $count
     *
     * @return string
     */
    protected function generateStoryHtml($story, $count)
    {
        $content = '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">'
            . $count['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        return $content;
    }
}