<?php
namespace app\components\feed;

/**
 * Allows to create a valid RSS 2.0 feeds.
 * @version 0.1
 *
 * @author Alexander Makarov
 * @link http://rmcreative.ru/
 * @see http://cyber.law.harvard.edu/rss/rss.html
 */
class Feed
{
    /**
     * The name of the channel. It's how people refer to your service.
     * If you have an HTML website that contains the same information as your
     * RSS file, the title of your channel should be the same as the title of
     * your website.
     *
     * @var string
     */
    public $title;

    /**
     * The URL to the HTML website corresponding to the channel.
     *
     * @var string
     */
    public $link;

    /**
     * The URL where this RSS feed appears
     *
     * @var string
     */
    public $selfLink;

    /**
     * Phrase or sentence describing the channel.
     *
     * @var string
     */
    public $description;

    /**
     * The language the channel is written in. This allows aggregators to
     * group all Italian language sites, for example, on a single page. A list
     * of allowable values for this element, as provided by Netscape, is
     * <a href="http://cyber.law.harvard.edu/rss/languages.html">here</a>.
     * You may also use <a href="http://www.w3.org/TR/REC-html40/struct/dirlang.html#langcodes">values defined</a>
     * by the W3C.
     *
     * @var string
     */
    public $language;

    /**
     * Copyright notice for content in the channel.
     *
     * @var string
     */
    public $copyright;

    /**
     * Email address for person responsible for editorial content.
     * @var array
     */
    protected $managingEditor;

    /**
     * Email address for person responsible for technical issues relating to channel.
     *
     * @var array
     */
    protected $webMaster;

    /**
     * The publication date for the content in the channel. For example, the
     * New York Times publishes on a daily basis, the publication date flips
     * once every 24 hours. That's when the pubDate of the channel changes.
     *
     * @var int unix timestamp
     */
    public $pubDate;

    /**
     * The last time the content of the channel changed.
     *
     * @var int unix timestamp
     */
    public $lastBuildDate;

    /**
     * @todo: implement
     * @var string
     */
    public $category;

    /**
     * A URL that points to the documentation for the format used in the RSS file.
     *
     * @var string
     */
    protected $docs = 'http://blogs.law.harvard.edu/tech/rss';

    /**
     * A string indicating the program used to generate the channel.
     *
     * @var string
     */
    public $generator;

    public $ttl;

    /**
     * Items storage
     *
     * @var Item[]
     */
    private $items = [];

    /**
     * Person responsible for technical issues relating to channel.
     *
     * @param string $email
     * @param string $name
     */
    public function setManagingEditor($email, $name) {
        $this->managingEditor = [$email, $name];
    }

    /**
     * Person responsible for technical issues relating to channel.
     *
     * @param string $email
     * @param string $name
     */
    public function setWebMaster($email, $name) {
        $this->webMaster = [$email, $name];
    }

    /**
     * Add feed item
     * @param Item $item
     * @throws Exception
     */
    public function addItem(Item $item) {
        if(empty($item->title) && empty($item->description)) {
            throw new Exception('At least one of title or description must be defined.');
        }

        $this->items[] = $item;
    }

    private function validateChannel() {
        if(empty($this->title)) throw new Exception('Missing channel title.');
        if(empty($this->link)) throw new Exception('Missing channel link.');
        if(empty($this->description)) throw new Exception('Missing channel description.');
    }

    public function fetch() {
        $this->validateChannel();

        $out ='<?xml version="1.0"?>'."\n";
        $out.='<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'."\n";

        $out.="\t<channel>\n";

        $out.=Feed::renderTag('title', Feed::cdata($this->title), 2);
        $out.=Feed::renderTag('link', $this->link, 2);

        if(!empty($this->selfLink)) {
            $out.="\t\t".'<atom:link href="'.$this->selfLink.'" rel="self" type="application/rss+xml" />'."\n";
        }

        $out.=Feed::renderTag('description', $this->description, 2);
        $out.=Feed::renderTag('language', $this->language, 2);
        $out.=Feed::renderTag('pubDate', Feed::convertTime($this->pubDate), 2);
        $out.=Feed::renderTag('lastBuildDate', Feed::convertTime($this->lastBuildDate), 2);
        $out.=Feed::renderTag('docs', $this->docs, 2);
        $out.=Feed::renderTag('generator', $this->generator, 2);

        $out.=Feed::renderTag(
            'managingEditor',
            $this->managingEditor[0].' ('.$this->managingEditor[1].')',
            2
        );
        $out.=Feed::renderTag(
            'webMaster',
            $this->webMaster[0].' ('.$this->webMaster[1].')',
            2
        );

        foreach ($this->items as $item) {
            $out.=$item;
        }

        $out.="\t</channel>\n";

        $out.='</rss>';

        return $out;
    }

    public function render() {
        header('Content-Type: application/rss+xml');
        echo $this->fetch();
        die();
    }

    static function renderTag($tagname, $value, $tabs = 0) {
        if(empty($value)) return '';
        return str_repeat("\t", $tabs)."<$tagname>$value</$tagname>\n";
    }

    static function convertTime($timestamp) {
        if(empty ($timestamp)) return '';
        return gmdate('r', $timestamp);
    }

    static function cdata($text) {
        return '<![CDATA['.$text.']]>';
    }

    static function escape($text) {
        return htmlentities($text, ENT_QUOTES, 'UTF-8');
    }
}



