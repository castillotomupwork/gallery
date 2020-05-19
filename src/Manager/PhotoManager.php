<?php

namespace App\Manager;

use Samwilson\PhpFlickr\PhpFlickr;
use Samwilson\PhpFlickr\PhotosApi;

/**
 * Class PhotoManager
 *
 * @package App\Manager
 */
class PhotoManager
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * PhotoManager constructor.
     *
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;

        $this->apiSecret = $apiSecret;
    }

    /**
     * @param string $tag
     */
    public function getManyPhotos(string $tag)
    {
        $flickr = new PhpFlickr($this->apiKey, $this->apiSecret);

        $tagRequest = $flickr->tags_getClusterPhotos($tag, '');

        $photos = null;
        $cnt = 0;
        if ($tagRequest['stat'] === 'ok') {
            foreach ($tagRequest['photos']['photo'] as $item) {
                if ($item['id'] && $item['ispublic'] == 1) {

                    try {
                        $photoRequest = $flickr->photos()->getSizes($item['id']);

                        $urlRequest = $flickr->urls()->getImageUrl($item, 'square_150');

                        if ($photoRequest === false || $urlRequest === false) {
                            continue;
                        } else {
                            $photos[] = [
                                'url' => $urlRequest,
                                'item' => json_encode($item)
                            ];
                            $cnt++;

                            if ($cnt >= 15) {
                                break;
                            }
                        }
                    } catch (\Exception $ex) {
                        continue;
                    }
                }
            }
        }

        return $photos;
    }

    public function getOnePhoto($item)
    {
        $nullRet = ['url' => null, 'info' => null];

        $flickr = new PhpFlickr($this->apiKey, $this->apiSecret);

        try {
            $photoRequest = $flickr->photos()->getSizes($item['id']);
            $infoRequest = $flickr->photos()->getInfo($item['id']);
            $urlRequest = $flickr->urls()->getImageUrl($item, 'medium');

            if ($photoRequest === false || $infoRequest === false || $urlRequest === false) {
                return $nullRet;
            } else {
                return ['url' => $urlRequest, 'info' => $infoRequest];
            }
        } catch (\Exception $ex) {
            return $nullRet;
        }
    }
}