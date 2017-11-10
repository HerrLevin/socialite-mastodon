<?php

namespace Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

use Illuminate\Http\Request;
use Laravel\Socialite\SocialiteManager;

use Revolution\Socialite\Mastodon\MastodonProvider;

class SocialiteTest extends TestCase
{
    /**
     * @var SocialiteManager
     */
    protected $socialite;

    public function setUp()
    {
        parent::setUp();

        $app = ['request' => Request::create('foo')];

        $this->socialite = new SocialiteManager($app);

        $this->socialite->extend('mastodon', function ($app) {
            return $this->socialite->buildProvider(MastodonProvider::class, [
                'client_id'     => 'test',
                'client_secret' => 'test',
                'redirect'      => 'https://localhost',
            ]);
        });
    }

    public function testInstance()
    {
        $provider = $this->socialite->driver('mastodon');

        $this->assertInstanceOf(MastodonProvider::class, $provider);
    }
}