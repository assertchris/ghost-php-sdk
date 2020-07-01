<?php

namespace GameMakerAcademy\GhostApi;

use GuzzleHttp\Client;

class ContentClient
{
    protected $domain;
    protected $key;
    protected $client;

    const PREFIX = '/ghost/api/v3/content';

    public function __construct(string $domain, string $key)
    {
        $this->domain = $domain;
        $this->key = $key;

        $this->client = new Client();
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getPages(array $params = []): object
    {
        return $this->request('/pages', $params);
    }

    public function getPage(array $params): object
    {
        return $this->requestByIdOrSlug('pages', $params);
    }

    public function getPosts(array $params = []): object
    {
        return $this->request('/posts', $params);
    }

    public function getPost(array $params): object
    {
        return $this->requestByIdOrSlug('posts', $params);
    }

    public function getTags(array $params = []): object
    {
        return $this->request('/tags', $params);
    }

    public function getTag(array $params): object
    {
        return $this->requestByIdOrSlug('tags', $params);
    }

    public function getAuthors(array $params = []): object
    {
        return $this->request('/authors', $params);
    }

    public function getAuthor(array $params): object
    {
        return $this->requestByIdOrSlug('authors', $params);
    }

    protected function requestByIdOrSlug(string $type, array $params = []): object
    {
        if (empty($params['id']) and empty($params['slug'])) {
            throw new ContentClientException('missing id and slug');
        }

        if ($params['id']) {
            return $this->request('/' . $type . '/' . $params['id'], $params);
        }

        return $this->request('/' . $type . '/slug/' . $params['slug'], $params);
    }

    protected function request(string $endpoint, array $params = []): object
    {
        $url = $this->domain . static::PREFIX . $endpoint . '?key=' . $this->key;

        if (!empty($params['filter'])) {
            $url .= '&filter=' . $params['filter'];
        }

        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            $exception = new ContentClientException();
            $exception->setGuzzleResponse = $response;
            throw $exception;
        }

        return json_decode((string) $response->getBody());
    }
}
