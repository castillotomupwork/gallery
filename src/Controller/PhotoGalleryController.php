<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PhotoGalleryController extends AbstractController
{
    
    /**
     * @Route("/", name="gallery", methods={"GET"})
     */
    public function galleryAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        
        return $this->render('photo_gallery/gallery.html.twig', ['categories' => $categories]);
    }
    
    
    /**
     * @Route("/photo_gallery/tag/{tag}", name="photo_gallery_tag", methods={"GET"})
     */
    public function tagAction($tag, $photoManager)
    {
        $photos = $photoManager->getManyPhotos($tag);
        
        return $this->render('photo_gallery/tag.html.twig', [
            'tag' => $tag,
            'photos' => $photos
        ]);
    }
    
    /**
     * @Route("/photo_gallery/item/{tag}", name="photo_gallery_item", methods={"POST"})
     */
    public function itemAction(Request $request, $tag, $photoManager)
    {
        $item = $request->request->get('item');

        $item = json_decode($item, true);

        $details = $photoManager->getOnePhoto($item);

        return $this->render('photo_gallery/item.html.twig', [
                'tag' => $tag,
                'url' => $details['url'],
                'info' => $details['info']
            ]);
    }
}
