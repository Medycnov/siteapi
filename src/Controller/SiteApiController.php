<?php

namespace Drupal\siteapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Drupal\node\Entity\Node;
/**
 * Class SiteApiController.
 */
class SiteApiController extends ControllerBase {

  /**
   * Get.
   *
   * @return string
   *   Return node json.
   */
  public function get($nid) {
    $site_api_key = \Drupal::config('api_key.settings')->get('siteapikey');

    if ($site_api_key=='No API Key yet' || $site_api_key==''){
      $data = ['message' => 'access denied'];
    }else{
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if ($node instanceof Node && $node->getType() == 'page') {
        $data = $node->toArray();
      }else{
        $data = ['message' => 'the Node id not exist '];
      }
    }
    return new JsonResponse($data);
  }

}
