<?php

namespace Tests\Context;

use LuckPermsAPI\Context\Context;
use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Context\ContextMapper;
use Tests\TestCase;

class ContextMapperTest extends TestCase {

    public function test_context_mapper_can_map_context_data_to_context_objects(): void {
        $contextData = [
            [
                'key' => 'world',
                'value' => 'hub',
            ],
            [
                'key' => 'server',
                'value' => 'lobby',
            ],
            [
                'key' => 'server',
                'value' => 'survival-1',
            ],
        ];

        $contexts = resolve(ContextMapper::class)->map($contextData);

        $this->assertCount(3, $contexts);

        foreach ($contexts->all() as $context) {
            $this->assertInstanceOf(Context::class, $context);
        }

        $this->assertEquals(ContextKey::World, $contexts->get(0)->key());
        $this->assertEquals('hub', $contexts->get(0)->value());
        $this->assertEquals(ContextKey::Server, $contexts->get(1)->key());
        $this->assertEquals('lobby', $contexts->get(1)->value());
        $this->assertEquals(ContextKey::Server, $contexts->get(2)->key());
        $this->assertEquals('survival-1', $contexts->get(2)->value());
    }

}
