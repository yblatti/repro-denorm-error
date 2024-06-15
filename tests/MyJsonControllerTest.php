<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyJsonControllerTest extends WebTestCase
{
    public function test_It_deserializes_with_good_value(): void
    {
        $client = static::createClient([], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        // Request a specific page
        $client->request(
            'PATCH',
            '/edit',
            [],
            [],
            ['HTTP_Accept' => 'application/json'],
            json_encode(['rootFields' => 'baseValue', 'mySpecialField' => ['key' => 'goodValue']]));

        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(json_encode(['rootFields' => 'baseValue', 'mySpecialField' => ['key' => 'goodValue']]), $responseContent);
    }

    public function test_I_get_a_clear_message_if_deserialization_is_not_possible(): void
    {
        $client = static::createClient([], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        // Request a specific page
        $client->request(
            'PATCH',
            '/edit',
            [],
            [],
            ['HTTP_Accept' => 'application/json'],
            json_encode(['rootFields' => 'baseValue', 'mySpecialField' => ['key' => 'veryBadValueItCannotProcess']]));

        $response = $client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseStatusCodeSame(422, $response->getStatusCode());
        $this->assertJson($responseContent);

        $responseArray = json_decode($responseContent, true);

        $this->assertEquals('mySpecialField.key: This value should be of type ValidTypeIExpect.', $responseArray['detail']);
        $this->assertEquals('A clear message for the end user', $responseArray['violations'][0]['hint']);
    }
}
