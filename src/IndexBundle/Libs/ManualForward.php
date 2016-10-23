<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 10. 18.
 * Time: 20:44
 */
namespace IndexBundle\Libs;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;

class ManualForward {

    protected $request;
    protected $kernel;

    public function __construct(HttpKernelInterface $kernel)
    {
        $this->kernel  = $kernel;
       // $this->request = $request;
    }

    public function handleForward($request, $bundleName = 'IndexBundle', $className, $functionName)
    {
        $this->request = $request;
        $controller = $bundleName.':'.$className.':'.$functionName;
        $path = [
            '_controller' => $controller
        ];
        $subRequest = $this->request->duplicate(array(), null, $path);

        return $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
}