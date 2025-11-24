<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
    protected Request $request;
    protected TemplateViewerInterface $viewer;

    protected Response $response;

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function setViewer(TemplateViewerInterface $viewer): void
    {
        $this->viewer = $viewer;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}