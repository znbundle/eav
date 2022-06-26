<?php

namespace ZnBundle\Eav\Symfony4\Admin\Controllers;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnLib\Web\Components\Url\Helpers\Url;
use ZnLib\Web\Components\Controller\BaseWebCrudController;
use ZnLib\Web\Components\Controller\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Components\TwBootstrap\Widgets\Breadcrumb\BreadcrumbWidget;

class AttributeController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/attribute';
    protected $baseUri = '/eav/attribute';

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        AttributeServiceInterface $service
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);

        $title = 'EAV attribute';
        $this->getBreadcrumbWidget()->add($title, Url::to([$this->getBaseUri()]));
    }


}
