<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Group\UserGroup;
use LuckPermsAPI\Permission\Permission;
use LuckPermsAPI\Session;
use LuckPermsAPI\User\UserRepository;
use Psr\Http\Message\StreamInterface;

class UserRepositoryTest extends \PHPUnit\Framework\TestCase {

    public function test_load_will_return_user_if_valid() {
        $session = $this->createMock(Session::class);
        $httpClient = $this->createMock(Client::class);
        $session->httpClient = $httpClient;
        $httpClient->method('get')->willReturn($response = $this->createMock(Response::class));
        $response->method('getBody')->willReturn($body = $this->createMock(StreamInterface::class));
        $body->method('getContents')->willReturn(json_encode([
            'uniqueId' => '9490b898-856a-4aae-8de3-2986d007269b',
            'username' => 'Aberdeener',
            'nodes' => [
                [
                    'key' => 'group.staff',
                    'type' => 'inheritance',
                    'value' => 'true',
                    'context' => [
                        [
                            'key' => 'world',
                            'value' => 'survival',
                        ],
                    ],
                ],
                [
                    'key' => 'group.member',
                    'type' => 'inheritance',
                    'value' => 'true',
                    'context' => [],
                    'expiry' => 1111111111,
                ],
                [
                    'key' => 'minecraft.command.ban',
                    'type' => 'permission',
                    'value' => 'true',
                    'context' => [
                        [
                            'key' => 'server',
                            'value' => 'lobby',
                        ],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR));

        $user = UserRepository::get($session)->load('9490b898-856a-4aae-8de3-2986d007269b');

        $this->assertSame('9490b898-856a-4aae-8de3-2986d007269b', $user->uniqueId());
        $this->assertSame('Aberdeener', $user->username());

        $this->assertCount(3, $user->rawNodes());

        $this->assertCount(2, $user->groups());
        $group = $user->groups()->first();
        $this->assertInstanceOf(UserGroup::class, $group);
        $this->assertSame('staff', $group->name());
        $this->assertTrue($group->value());
        $this->assertCount(1, $group->contexts());
        $this->assertSame(ContextKey::World, $group->contexts()->first()->key());
        $this->assertSame('survival', $group->contexts()->first()->value());
        $group = $user->groups()->last();
        $this->assertInstanceOf(UserGroup::class, $group);
        $this->assertSame('member', $group->name());
        $this->assertTrue($group->value());
        $this->assertCount(0, $group->contexts());
        $this->assertSame(1111111111, $group->expiry());

        $this->assertCount(1, $user->permissions());
        $this->assertInstanceOf(Permission::class, $user->permissions()->first());
        $this->assertSame('minecraft.command.ban', $user->permissions()->first()->name());
        $this->assertTrue($user->permissions()->first()->value());
        $this->assertCount(1, $user->permissions()->first()->contexts());
        $this->assertSame(ContextKey::Server, $user->permissions()->first()->contexts()->first()->key());
        $this->assertSame('lobby', $user->permissions()->first()->contexts()->first()->value());
    }

}
