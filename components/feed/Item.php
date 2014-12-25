<?php
namespace app\components\feed;

/**
 * Feed item
 */
class Item
{
    /**
     * The title of the item.
     *
     * @var string
     */
    public $title;

    /**
     * The URL of the item.
     *
     * @var string
     */
    public $link;

    /**
     * The item text.
     *
     * @var string
     */
    public $description;

    /**
     * @todo: implement
     * It's recommended to use full path: software/antivirus/kaspersky.
     * can containg domain attribute
     * many categories allowed
     * @var array
     */
    private $categories = [];

    /**
     * URL of a page for comments relating to the item.
     * @var string
     */
    private $comments;

    /**
     * @todo: implement
     * @var string
     */
    private $enclosure;

    /**
     * Indicates when the item was published.
     *
     * @var int unix timestamp
     */
    public $pubDate;

    /**
     * A string that uniquely identifies the item.
     *
     * @example http://inessential.com/2002/09/01.php#a2
     * @var string
     */
    public $guid;

    /**
     * Email address and name of the author of the item.
     *
     * @var array
     */
    private $author;

    /**
     * Set email address and name of the author of the item.
     *
     * @param string $email
     * @param string $name
     */
    public function setAuthor($email, $name) {
        $this->author = [$email, $name];
    }

    /**
     * @var string
     */
    private $source;

    public function __toString() {
        $out = "\t\t<item>\n";

        $out.=Feed::renderTag('title', Feed::cdata($this->title), 3);
        $out.=Feed::renderTag('link', $this->link, 3);
        $out.=Feed::renderTag('description', Feed::cdata($this->description), 3);
        $out.=Feed::renderTag('guid', $this->guid, 3);
        $out.=Feed::renderTag('pubDate', Feed::convertTime($this->pubDate), 3);
        $out.=Feed::renderTag(
            'author',
            $this->author[0].' ('.$this->author[1].')',
            2
        );

        return $out."\t\t</item>\n";
    }
}