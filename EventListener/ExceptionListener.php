<?php

namespace Awesomite\ErrorDumperBundle\EventListener;

use Awesomite\ErrorDumper\Cloners\ClonedException;
use Awesomite\ErrorDumper\Views\ViewHtml;
use Awesomite\ErrorDumperBundle\Editors\CustomEditor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * @internal
 */
class ExceptionListener
{
    private $urlPattern;

    public function __construct($urlPattern = null)
    {
        $this->urlPattern = $urlPattern;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = new Response();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        ob_start();
        $view = new ViewHtml();
        if (!is_null($this->urlPattern)) {
            $view->setEditor(new CustomEditor($this->urlPattern));
        }
        $view->display(new ClonedException($exception));
        $content = ob_get_contents();
        ob_end_clean();
        $response->setContent($content);

        $event->setResponse($response);
    }
}
