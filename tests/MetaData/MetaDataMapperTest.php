<?php

namespace Tests\MetaData;

use LuckPermsAPI\MetaData\MetaDataMapper;
use Tests\TestCase;

class MetaDataMapperTest extends TestCase {

    public function test_metadata_mapper_can_map_metadata_data_to_metadata_object(): void {
        $metadataData = [
            'meta' => [
                'test' => 'test',
                'test2' => 'test2',
                'test3' => 'test3',
            ],
        ];

        $metaData = resolve(MetaDataMapper::class)->map($metadataData);

        $this->assertEquals($metadataData['meta'], $metaData->meta()->toArray());
    }
}
