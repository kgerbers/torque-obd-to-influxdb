<?php

/**
 * Simple class for representing a request, for heavier projects I recommend using a beter class
 */
class Request {


    private \Illuminate\Support\Collection $query;
    private \Illuminate\Support\Collection $body;
    private \Illuminate\Support\Collection $headers;
    function __construct()
    {
        $this->query = collect();
        $this->body = collect();
        $this->headers = collect();
        foreach ($_GET as $k => $v) {
            $this->sanitize($k);
            $this->sanitize($v);

            $this->query->put($k, $v);
        }

        foreach ($_POST as $k => $v) {
            $this->sanitize($k);
            $this->sanitize($v);

            $this->body->put($k, $v);
        }

        foreach (getallheaders() as $k => $v) {
            $this->sanitize($k);
            $this->sanitize($v);

            $this->headers->put($k, $v);
        }
    }

    public function getQuery(): \Illuminate\Support\Collection
    {
        return $this->query;
    }

    public function getBody(): \Illuminate\Support\Collection
    {
        return $this->body;
    }

    public function getAll(): \Illuminate\Support\Collection
    {
        return $this->query->merge($this->body);
    }

    public function get($key, $default = null): mixed
    {
        return $this->query->merge($this->body)->get($key, $default);
    }

    public function has($key): bool
    {
        return $this->query->merge($this->body)->has($key);
    }

    /**
     * Test url: ?eml=example@example.com&session=fdsa4fsdafdsa&id=dsafa3afdsfsdfdsfs&v=2<script>&1=dsfas
     * @param $input
     * @return int|string
     */
    protected function sanitize(&$input): int|string
    {
        $input = trim(strip_tags($input));

        if(is_numeric($input)) {
            $input = (int) $input;
        }

        return $input;
    }
}