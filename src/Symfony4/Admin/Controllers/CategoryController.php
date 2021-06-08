<?php

namespace ZnBundle\Eav\Symfony4\Admin\Controllers;

use App\User\Domain\Enums\Rbac\AppUserPermissionEnum;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Symfony4\MicroApp\Traits\ControllerFormTrait;
use ZnLib\Web\Widgets\BreadcrumbWidget;

class CategoryController extends BaseWebCrudController implements ControllerAccessInterface
{

    use ControllerFormTrait;

    protected $viewsDir = __DIR__ . '/../views/category';
    protected $toastrService;
    protected $breadcrumbWidget;
    protected $service;

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        CategoryServiceInterface $service
    )
    {
        $this->service = $service;
        $this->toastrService = $toastrService;
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);

        $this->breadcrumbWidget = $breadcrumbWidget;
        $title = 'EAV category';
        $this->breadcrumbWidget->add($title, Url::to(['/eav/category']));
        $this->getView()->addAttribute('title', $title);
    }

    public function access(): array
    {
        return [
            'index' => [
                AppUserPermissionEnum::PERSON_INFO_UPDATE,
            ],
        ];
    }
}
