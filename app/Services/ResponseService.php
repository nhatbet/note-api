<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    public array $payload;

    public function __construct()
    {
        $this->payload = [];
    }

    public function setMsg(string $msg): self
    {
        $this->payload['message'] = $msg;
        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->payload['status'] = $status;
        return $this;
    }

    public function setData($data = []): self
    {
        // TODO: check detail, collection...
        $this->payload['data'] = $data;
        // switch (true) {
        //     case $data instanceof AnonymousResourceCollection:
        //     case $data instanceof Collection:
        //         $this->payload['data'] = $data;
        //         break;

        //     default:
        //         # code...
        //         break;
        // }

        return $this;
    }

    public function setSuccess($data = []): self
    {
        $this->setData($data)->setStatus(Response::HTTP_OK)->setMsg('ok');

        return $this;
    }

    public function getSuccess($data = []): JsonResponse
    {
        $this->setSuccess($data);

        return $this->get();
    }

    public function getError(): JsonResponse
    {
        $this->setStatus(Response::HTTP_BAD_REQUEST)->setMsg('Error.');

        return $this->get();
    }

    public function getPaginator(LengthAwarePaginator $paginator, string $resourceClass): JsonResponse
    {
        $data = [
            'current_page' => $paginator->currentPage(),
            'next_page_url' => $paginator->nextPageUrl(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'data' => $resourceClass::collection($paginator->getCollection())
        ];

        return $this->setSuccess($data)->get();
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function get(): JsonResponse
    {
        return response()->json($this->getPayload());
    }
}
