<?php
/**
 * Created by PhpStorm.
 * User: ned
 * Date: 26/04/2018
 * Time: 08:34
 */

namespace App\Service;


use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Simple\FilesystemCache;

class Playlist {

	private $clientId;

	private $clientSecret;

	/**
	 * @var FilesystemCache
	 */
	private $cache;


	public function __construct($clientId, $clientSecret) {
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->cache = new FilesystemAdapter('app.service.playlist');
	}

	/**
	 * @return string temporary spotify access token
	 */
	public function getAccessToken()
	{
		$accessToken = $this->cache->getItem('access_token');

		if (!$accessToken->isHit()) {
			$session = new Session(
				$this->clientId,
				$this->clientSecret
			);
			$session->requestCredentialsToken();
			$accessToken->expiresAfter(3600);
			$this->cache->save($accessToken->set($session->getAccessToken()));
		}

		return $accessToken->get();
	}

	/**
	 * @return object
	 */
	public function getTracks()
	{
		$api = new SpotifyWebAPI();

		$api->setAccessToken($this->getAccessToken());

		$tracks = $this->cache->getItem('tracks');

		if (!$tracks->isHit()) {
			$tracks->set($api->getUserPlaylistTracks('filtr','1zkiBMkvqggGR0yTTuvQLh'));
			$tracks->expiresAfter(3600);
			$this->cache->save($tracks);
		}

		return $tracks->get();
	}



}