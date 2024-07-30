<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Response
{
    private mixed $data;
    private mixed $pagination;
    private string $reason;
    private int $status;

    public function __construct(string $reason = '', int $status = 200, mixed $data = null, mixed $pagination = null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->pagination = $pagination;
        $this->reason = $reason;
    }

    public function getJsonResponse(): JsonResponse
    {
        $response = [];

        if (!empty($this->reason) || ($this->status < 200 || $this->status >= 300)) {
            $response['message'] = $this->reason ?: 'Internal Server Error';
        }

        if (!is_null($this->data)) {
            $response['data'] = $this->data;
        }

        if (!is_null($this->pagination)) {
            $response['pagination'] = $this->pagination;
        }

        return response()->json($response, $this->status);
    }

    static public function success(mixed $data = null, string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::OK, $data);
    }

    static public function successWithPagination(mixed $data = null, mixed $pagination = null, string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::OK, $data, $pagination);
    }

    static public function error(string $reason = '', int $status = HttpStatus::INTERNAL_SERVER_ERROR, mixed $data = null): Response
    {
        return new Response($reason, $status, $data);
    }

    static public function notFound(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::NOT_FOUND, $data);
    }

    static public function accepted(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::ACCEPTED, $data);
    }

    static public function unauthorized(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::UNAUTHORIZED, $data);
    }

    static public function forbidden(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::FORBIDDEN, $data);
    }

    static public function created(mixed $data = null, string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::CREATED, $data);
    }

    static public function noContent(string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::NO_CONTENT);
    }

    static public function updated(mixed $data = null, string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::OK, $data);
    }

    static public function deleted(string $reason = ''): Response
    {
        return new Response($reason, HttpStatus::OK);
    }


    static public function badRequest(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::BAD_REQUEST, $data);
    }

    static public function methodNotAllowed(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::METHOD_NOT_ALLOWED, $data);
    }

    static public function conflict(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::CONFLICT, $data);
    }

    static public function gone(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::GONE, $data);
    }

    static public function tooManyRequests(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::TOO_MANY_REQUESTS, $data);
    }

    static public function internalServerError(string $reason = '', mixed $data = null): Response
    {
        return new Response($reason, HttpStatus::INTERNAL_SERVER_ERROR, $data);
    }
}