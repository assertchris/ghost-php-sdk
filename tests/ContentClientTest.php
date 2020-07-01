<?php

namespace GameMakerAcademy\GhostApiTests;

use Dotenv\Dotenv;
use GameMakerAcademy\GhostApi\ContentClient;
use PHPUnit\Framework\TestCase;

class ContentClientTests extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->client = new ContentClient(
            $_ENV['GHOST_DOMAIN'],
            $_ENV['GHOST_CONTENT_KEY'],
        );
    }

    public function test_it_gets_some_posts()
    {
        $response = $this->client->getPosts();

        $this->assertTrue(count($response->posts) > 1);

        return $response->posts;
    }

    /**
     * @depends test_it_gets_some_posts
     */
    public function test_it_gets_some_posts_with_filters($posts)
    {
        $response = $this->client->getPosts(['filter' => 'tag:' . $_ENV['GHOST_FILTER_TAG']]);

        $this->assertTrue(
            count($response->posts) < count($posts),
            'Do you have more published posts than posts returned with the filtered tag?'
        );
    }

    /**
     * @depends test_it_gets_some_posts
     */
    public function test_it_gets_a_post($posts)
    {
        $response = $this->client->getPost(['id' => $posts[0]->id]);

        $this->assertEquals($response->posts[0]->id, $posts[0]->id);
    }
}
