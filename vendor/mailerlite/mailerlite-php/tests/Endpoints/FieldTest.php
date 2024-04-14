<?php

namespace MailerLite\Tests\Endpoints;

use Http\Mock\Client;
use MailerLite\Common\HttpLayer;
use MailerLite\Endpoints\Field;
use MailerLite\Tests\TestCase;
use Psr\Http\Message\ResponseInterface;

class FieldTest extends TestCase
{
    protected Field $fields;
    protected ResponseInterface $response;
    protected int $fieldId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client();

        $this->fields = new Field(new HttpLayer(self::OPTIONS, $this->client), self::OPTIONS);
        $this->fieldId = '123';

        $this->response = $this->createMock(ResponseInterface::class);
        $this->response->method('getStatusCode')->willReturn(200);
        $this->client->addResponse($this->response);
    }

    public function test_create()
    {
        $this->fields->create([]);

        $request = $this->client->getLastRequest();

        self::assertEquals('POST', $request->getMethod());
        self::assertEquals('/api/fields', $request->getUri()->getPath());
    }

    public function test_read_all()
    {
        $this->fields->get([]);

        $request = $this->client->getLastRequest();

        self::assertEquals('GET', $request->getMethod());
        self::assertEquals('/api/fields', $request->getUri()->getPath());
    }

    public function test_update()
    {
        $this->fields->update($this->fieldId, []);

        $request = $this->client->getLastRequest();

        self::assertEquals('PUT', $request->getMethod());
        self::assertEquals("/api/fields/{$this->fieldId}", $request->getUri()->getPath());
    }

    public function test_delete()
    {
        $this->fields->delete($this->fieldId);

        $request = $this->client->getLastRequest();

        self::assertEquals('DELETE', $request->getMethod());
        self::assertEquals("/api/fields/{$this->fieldId}", $request->getUri()->getPath());
    }
}
