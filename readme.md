# Ghost API

This is a basic client for managing Ghost CMS content.

**This is still very raw. Use at your own risk**

```
composer require gamemakeracademy/ghost-api
```

Then, query data:

```php
$content = new ContentClient(
    $_ENV['GHOST_DOMAIN'],
    $_ENV['GHOST_CONTENT_KEY'],
);

$response = $this->client->getPosts();

foreach ($response->posts as $post) {
    ...
}
```

## Roadmap

- Add support for admin actions
- Wrap responses in richer objects
