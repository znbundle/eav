<?php

namespace ZnBundle\Eav\Symfony4\Admin\Controllers;

use App\Common\Enums\Rbac\CommonPermissionEnum;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Widgets\BreadcrumbWidget;

class EntityController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/entity';
    protected $baseUri = '/eav/entity';

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        EntityServiceInterface $service
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);

        $title = 'EAV entity';
        $this->getBreadcrumbWidget()->add($title, Url::to([$this->getBaseUri()]));
    }

    public function access(): array
    {
        return [
            'index' => [
                CommonPermissionEnum::ADMIN_ONLY,
            ],
            'view' => [
                CommonPermissionEnum::ADMIN_ONLY,
            ],
            'update' => [
                CommonPermissionEnum::ADMIN_ONLY,
            ],
            'delete' => [
                CommonPermissionEnum::ADMIN_ONLY,
            ],
            'create' => [
                CommonPermissionEnum::ADMIN_ONLY,
            ],
        ];
    }
}
