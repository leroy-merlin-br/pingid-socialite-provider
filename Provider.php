<?php

namespace SocialiteProviders\PingID;

use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    private const LAST_MILE = 'lastmile';
    private const OPEN_ID = 'openid';
    private const PROFILE = 'profile';
    private const GROUPS = 'groups';
    private const REFLEX = 'reflex';
    private const OPUS = 'opus';
    private const OFFICE = 'office';
    private const TANGRAM = 'tangram';
    private const PRODUCTS_WRITE = 'products-write';
    private const PIIVO = 'piivo';
    private const OFFLINE_ACCESS = 'offline_access';
    private const PRODUCTS_READ = 'products-read';
    private const EMAIL = 'email';

    /**
     * Here you can set all scopes that you want to
     * set by default when authenticating with
     * PingID.
     *
     * @var string[]
     */
    protected $scopes = [
        self::OPEN_ID,
        self::PROFILE,
        self::EMAIL,
        self::ADV_PROFILE,
    ];

    private const ADV_PROFILE = 'advprofile';

    /**
     * Default url for ping ID acceptance.
     *
     * @todo make this configurable.
     */
    const BASE_URL = 'https://idpb2e-rec.adeo.com/';

    /**
     * Override default OAuth2 scope separator.
     * For PingID authentication, the scope separator is spaces.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /** @inheritdoc */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->mountUrl('as/authorization.oauth2'), $state);
    }

    /** @inheritdoc */
    protected function getTokenUrl()
    {
        return $this->mountUrl('as/token.oauth2');
    }

    /** @inheritdoc */
    protected function getUserByToken($token)
    {
        // @todo handle exceptions.
        $response = $this->getHttpClient()->get(
            $this->mountUrl('idp/userinfo.openid'),
            [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /** @inheritdoc */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user);
    }

    /** @inheritdoc */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    private function mountUrl(string $path): string
    {
        return self::BASE_URL . $path;
    }
}
