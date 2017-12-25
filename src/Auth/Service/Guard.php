<?php

namespace Lychee\Auth\Service;

use Silex\Application;
use Lychee\Auth\Data\GuardRepository;

class Guard
{
    protected $app;
    protected $cache;

    public function __construct(GuardRepository $repository, Application $app)
    {
        $this->repository = $repository;
        $this->app = $app;
        $this->cache = [];
    }

    public function isAuthenticated(): bool
    {
        return $this->app['session']->get('login') &&
            $this->app['session']->get('identifier') === $this->cache['identifier'];
    }

    public function matchPassword(string $password): bool
    {
        return ($password === $this->cache['password'] ||
            $this->cache['password'] === crypt($password, $this->cache['password'])
        );
    }

    public function matchUsername(string $username): bool
    {
        return ($username === $this->cache['username'] ||
            $this->cache['username'] === crypt($username, $this->cache['username'])
        );
    }

    public function matchCredential(string $username, string $password): bool
    {
        return $this->matchUsername($username) && $this->matchPassword($password);
    }

    public function credentialExists(): bool
    {
        return !$this->cache['username'] && !$this->cache['password'];
    }

    public function saveCredential(string $username, string $password): array
    {
        return $this->repository->saveCredential($username, $password);
    }

    public function getIdentifier(): string
    {
        return $this->cache['identifier'];
    }

    public function pull()
    {
        $this->cache = $this->repository->find();
    }
}
