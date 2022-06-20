<?php

namespace ZnBundle\Eav\Tests\Unit;

use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Services\EntityService;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnTool\Test\Base\BaseRestApiTest;

include __DIR__ . '/../bootstrap.php';

class DataTest extends BaseRestApiTest
{

    protected $basePath = 'v1';

    protected function fixtures(): array
    {
        return [
            'eav_category',
            'eav_entity',
            'eav_entity_attribute',
            'eav_enum',
            'eav_attribute',
            'eav_validation',
            'eav_measure',
            'user_credential',
            'auth_assignment',
        ];
    }

//    public function testValidateEntity()
//    {
//        $body = [
//            'season' => 'summer',
//            'volume' => '6',
//        ];
//        $entityService = $this->getService();
//        $query = new Query();
//        $query->with([
//            'attributesTie.attribute',
//            'attributesTie.attribute.enums',
//            'attributesTie.attribute.unit',
//        ]);
//        /** @var EntityEntity $entity */
//        $entity = $entityService->oneById(1, $query);
//        dd($entity->getAttributes());
//        $this->assertEquals($body, EntityHelper::toArray($entity));
//    }

    private function getService(): EntityService
    {
        $container = ContainerHelper::getContainer();
        /** @var EntityService $entityService */
        $entityService = $container->get(EntityService::class);
        return $entityService;
    }
}
